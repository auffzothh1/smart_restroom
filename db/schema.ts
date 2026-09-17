import { pgTable, serial, text, integer, timestamp } from "drizzle-orm/pg-core";

/** Dashboard accounts. Passwords are stored as scrypt digests, never plaintext. */
export const users = pgTable("users", {
  id: serial().primaryKey(),
  name: text().notNull(),
  email: text().notNull().unique(),
  passwordHash: text("password_hash").notNull(),
  createdAt: timestamp("created_at", { withTimezone: true }).defaultNow().notNull(),
});

/** Single-row table (id = 1) holding the alert thresholds. */
export const settings = pgTable("settings", {
  id: integer().primaryKey(),
  soapThreshold: integer("soap_threshold").notNull().default(20),
  wasteThreshold: integer("waste_threshold").notNull().default(80),
});

/** One row per sensor report. */
export const sensorData = pgTable("sensor_data", {
  id: serial().primaryKey(),
  soapLevel: integer("soap_level").notNull(),
  wasteLevel: integer("waste_level").notNull(),
  status: text().notNull(),
  createdAt: timestamp("created_at", { withTimezone: true }).defaultNow().notNull(),
});

/** Alerts raised when a reading crosses a threshold. */
export const alerts = pgTable("alerts", {
  id: serial().primaryKey(),
  type: text().notNull(),
  message: text().notNull(),
  createdAt: timestamp("created_at", { withTimezone: true }).defaultNow().notNull(),
});

/** Server-generated secrets (session signing key, sensor API key). */
export const appConfig = pgTable("app_config", {
  key: text().primaryKey(),
  value: text().notNull(),
});
