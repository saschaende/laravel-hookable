<?php

namespace SaschaEnde\Hookable;

/**
 * BladeHooks ist eine Klasse, die ein einfaches Hook-System implementiert.
 * Sie ermöglicht das Hinzufügen und Ausführen von "Actions" (für zusätzliche Inhalte)
 * und "Filters" (für die Modifikation von Werten).
 */
class Hookable
{
    // Speichert registrierte Actions
    protected static array $actions = [];
    // Speichert registrierte Filter
    protected static array $filters = [];

    /**
     * Registriert eine neue Action (Hook, der Inhalte hinzufügen kann).
     *
     * @param string $name Der Name der Action.
     * @param callable $callback Die Callback-Funktion, die ausgeführt wird.
     * @param int $priority Die Priorität der Action (niedrigere Werte werden zuerst ausgeführt).
     */
    public static function action(string $name, callable $callback, int $priority = 10): void
    {
        self::$actions[$name][$priority][] = $callback;
        ksort(self::$actions[$name]);
    }

    /**
     * Führt alle registrierten Actions für einen bestimmten Namen aus und gibt die Ergebnisse als String zurück.
     *
     * @param string $name Der Name der Action.
     * @param mixed ...$params Zusätzliche Parameter, die an die Callback-Funktionen übergeben werden.
     * @return string Verkettete Rückgaben aller ausgeführten Callbacks.
     */
    public static function renderActions(string $name, ...$params): string
    {
        // Wenn keine Actions registriert sind → leer zurück
        if (!isset(self::$actions[$name])) {
            return '';
        }

        $output = '';

        // Prioritäten nach Reihenfolge ausführen (falls gesetzt)
        ksort(self::$actions[$name]);

        foreach (self::$actions[$name] as $callbacks) {
            foreach ($callbacks as $callback) {
                if (!is_callable($callback)) {
                    continue;
                }

                try {
                    // Aufruf der Callback-Funktion mit den übergebenen Parametern
                    $result = $callback(...$params);
                    if ($result !== null && $result !== '') {
                        $output .= $result;
                    }
                } catch (\Throwable $e) {
                    // Fehler im Hook ignorieren, aber im Debug-Modus protokollieren
                    if (config('app.debug')) {
                        logger()->warning("Hook action error [$name]: " . $e->getMessage());
                    }
                }
            }
        }

        return $output;
    }

    /**
     * Registriert einen neuen Filter (Hook, der Werte modifizieren kann).
     *
     * @param string $name Der Name des Filters.
     * @param callable $callback Die Callback-Funktion, die ausgeführt wird.
     * @param int $priority Die Priorität des Filters (niedrigere Werte werden zuerst ausgeführt).
     */
    public static function filter(string $name, callable $callback, int $priority = 10): void
    {
        self::$filters[$name][$priority][] = $callback;
        ksort(self::$filters[$name]);
    }

    /**
     * Wendet alle registrierten Filter für einen bestimmten Namen auf einen Wert an.
     *
     * @param string $name Der Name des Filters.
     * @param mixed $value Der Ausgangswert, der modifiziert werden soll.
     * @param mixed ...$params Zusätzliche Parameter, die an die Callback-Funktionen übergeben werden.
     * @return mixed Der modifizierte Wert nach Anwendung aller Filter.
     */
    public static function applyFilters(string $name, mixed $value = null, ...$params): mixed
    {
        $output = $value;

        if (!empty(self::$filters[$name])) {
            foreach (self::$filters[$name] as $callbacks) {
                foreach ($callbacks as $callback) {
                    if (is_callable($callback)) {
                        try {
                            // Aufruf der Callback-Funktion mit dem aktuellen Wert und zusätzlichen Parametern
                            $result = $callback($output, ...$params);
                            if ($result !== null) {
                                $output = $result;
                            }
                        } catch (\Throwable $e) {
                            // Fehler im Hook ignorieren
                        }
                    }
                }
            }
        }

        return $output;
    }
}
