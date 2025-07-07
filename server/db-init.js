// server/db-init.js
require("dotenv").config();
const { Pool } = require("pg");

const pool = new Pool({
  user: process.env.PGUSER,
  host: process.env.PGHOST,
  database: process.env.PGDATABASE,
  password: process.env.PGPASSWORD,
  port: process.env.PGPORT,
});

async function createTable() {
  try {
    await pool.query(`
      CREATE TABLE IF NOT EXISTS concerts (
        id SERIAL PRIMARY KEY,
        artist_name VARCHAR(255) NOT NULL,
        venue VARCHAR(255) NOT NULL,
        concert_date DATE NOT NULL,
        concert_time TIME,
        ticket_price DECIMAL(10, 2),
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    `);
    console.log("Table 'concerts' créée (ou déjà existante)");
  } catch (err) {
    console.error("Erreur lors de la création de la table:", err);
    throw err;
  }
}

async function alterTable() {
  try {
    // Ajoute la colonne phone si elle n'existe pas
    await pool.query(`
      ALTER TABLE concerts
      ADD COLUMN IF NOT EXISTS phone VARCHAR(30);
    `);
    // Ajoute la colonne image_url si elle n'existe pas
    await pool.query(`
      ALTER TABLE concerts
      ADD COLUMN IF NOT EXISTS image_url TEXT;
    `);
    console.log("Colonnes 'phone' et 'image_url' ajoutées si besoin.");
  } catch (err) {
    console.error("Erreur lors de l'ajout des colonnes:", err);
    throw err;
  }
}

async function main() {
  try {
    await createTable();
    await alterTable();
  } finally {
    await pool.end();
    console.log("Connexion fermée.");
  }
}

main();
