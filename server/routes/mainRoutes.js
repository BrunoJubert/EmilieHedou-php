const express = require("express");
const router = express.Router();
const bcrypt = require("bcryptjs");
const { Pool } = require("pg");

const pool = new Pool({
  user: process.env.PGUSER,
  host: process.env.PGHOST,
  database: process.env.PGDATABASE,
  password: process.env.PGPASSWORD,
  port: process.env.PGPORT,
});

// Middleware admin
function requireAdmin(req, res, next) {
  if (req.session && req.session.user && req.session.user.role === "admin") {
    next();
  } else {
    res.redirect("/");
  }
}

// Politique de confidentialité
router.get("/confidentialite", (req, res) => {
  res.render("pages/confidentialite", { title: "Politique de confidentialité" });
});


// Home : aperçu de 2 concerts
router.get("/", async (req, res) => {
  try {
    const { rows: concerts } = await pool.query(
      "SELECT * FROM concerts ORDER BY concert_date ASC LIMIT 2"
    );
    res.render("pages/home", {
      title: "Accueil",
      concerts,
      showLoginModal: false,
      error: null,
    });
  } catch (err) {
    console.error(err);
    res.render("pages/home", {
      title: "Accueil",
      concerts: [],
      showLoginModal: false,
      error: "Erreur lors du chargement des concerts.",
    });
  }
});

// Tous les concerts
router.get("/concerts", async (req, res) => {
  try {
    const { rows: concerts } = await pool.query(
      "SELECT * FROM concerts ORDER BY concert_date ASC"
    );
    res.render("pages/concerts", { title: "Concerts", concerts });
  } catch (err) {
    console.error(err);
    res.status(500).send("Erreur serveur");
  }
});

// Connexion admin
router.get("/login", async (req, res) => {
  const { rows: concerts } = await pool.query(
    "SELECT * FROM concerts ORDER BY concert_date ASC LIMIT 2"
  );
  res.render("pages/home", { showLoginModal: true, error: null, concerts });
});

router.post("/login", async (req, res) => {
  const { username, password } = req.body;
  const { rows: concerts } = await pool.query(
    "SELECT * FROM concerts ORDER BY concert_date ASC LIMIT 2"
  );
  const result = await pool.query("SELECT * FROM users WHERE username = $1", [
    username,
  ]);
  if (result.rows.length === 0) {
    return res.render("pages/home", {
      showLoginModal: true,
      error: "Mauvais identifiant ou mot de passe",
      concerts,
    });
  }
  const user = result.rows[0];
  const isMatch = await bcrypt.compare(password, user.password);
  if (!isMatch) {
    return res.render("pages/home", {
      showLoginModal: true,
      error: "Mot de passe ou identifiant incorrect",
      concerts,
    });
  }
  req.session.user = {
    id: user.id,
    username: user.username,
    firstname: user.firstname,
    role: user.role,
  };
  res.redirect("/dashboard");
});

// CRUD concerts (admin)
router.post("/concerts", requireAdmin, async (req, res) => {
  const { artist, venue, date, time, phone, price, description, image_url } =
    req.body;
  try {
    await pool.query(
      `INSERT INTO concerts 
      (artist_name, venue, concert_date, concert_time, phone, ticket_price, description, image_url)
      VALUES ($1, $2, $3, $4, $5, $6, $7, $8)`,
      [
        artist,
        venue,
        date,
        time || null,
        phone || null,
        price || 0,
        description || "",
        image_url || null,
      ]
    );
    res.redirect("/dashboard?success=concert_added");
  } catch (err) {
    console.error(err);
    res.redirect("/dashboard?error=db_error");
  }
});

router.post("/concerts/:id", requireAdmin, async (req, res) => {
  const { artist, venue, date, time, phone, price, description, image_url } =
    req.body;
  try {
    await pool.query(
      `UPDATE concerts SET
        artist_name = $1,
        venue = $2,
        concert_date = $3,
        concert_time = $4,
        phone = $5,
        ticket_price = $6,
        description = $7,
        image_url = $8
      WHERE id = $9`,
      [
        artist,
        venue,
        date,
        time || null,
        phone || null,
        price || 0,
        description || "",
        image_url || null,
        req.params.id,
      ]
    );
    res.redirect("/dashboard?success=concert_updated");
  } catch (err) {
    console.error(err);
    res.redirect("/dashboard?error=db_error");
  }
});

router.delete("/concerts/:id", requireAdmin, async (req, res) => {
  try {
    await pool.query("DELETE FROM concerts WHERE id = $1", [req.params.id]);
    res.redirect("/dashboard?success=concert_deleted");
  } catch (err) {
    console.error(err);
    res.redirect("/dashboard?error=db_error");
  }
});

// Dashboard admin
router.get("/dashboard", requireAdmin, async (req, res) => {
  try {
    const { rows } = await pool.query(
      "SELECT * FROM concerts ORDER BY concert_date DESC"
    );
    res.render("pages/dashboard", { user: req.session.user, concerts: rows });
  } catch (err) {
    console.error(err);
    res.status(500).send("Erreur serveur");
  }
});

// Déconnexion
router.get("/logout", (req, res) => {
  req.session.destroy(() => {
    res.redirect("/");
  });
});

module.exports = router;
