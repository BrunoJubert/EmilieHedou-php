const express = require("express");
const session = require("express-session");
const path = require("path");
require("dotenv").config();

const app = express();
const mainRoutes = require("./routes/mainRoutes");

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

app.use(
  session({
    secret: process.env.SESSION_SECRET || "unSecretUltraLongEtComplexe",
    resave: false,
    saveUninitialized: false,
    cookie: { secure: false },
  })
);

// ⚠️ Place ce middleware APRÈS express-session
app.use((req, res, next) => {
  res.locals.user = req.session.user || null;
  next();
});

app.set("view engine", "ejs");
app.set("views", path.join(__dirname, "../views"));

const methodOverride = require("method-override");
app.use(methodOverride("_method"));

app.use(express.static(path.join(__dirname, "../public")));
app.use("/", mainRoutes);

const PORT = process.env.PORT || 8080;
app.listen(PORT, () => {
  console.log(`Serveur lancé sur http://localhost:${PORT}`);
});
