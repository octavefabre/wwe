<?php

namespace App\Helpers;

class SessionManager
{
    // Démarre la session si elle n'est pas déjà active
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Enregistre une variable en session
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    // Récupère une variable de session (ou null si elle n'existe pas)
    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    // Supprime une variable de session
    public static function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    // Détruit toute la session
    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

    // Vérifie si une clé est définie
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}