<?php

function plugin_init_prets() {
    global $PLUGIN_HOOKS;

    // Enregistrement de la classe principale
    Plugin::registerClass('PluginPretsPret');

    // Ajout au menu
    include_once __DIR__ . '/inc/menu.php';
    $PLUGIN_HOOKS['menu_toadd']['prets'] = ['admin' => 'PluginPretsMenu'];

    // Sécurité CSRF
    $PLUGIN_HOOKS['csrf_compliant']['prets'] = true;
}

function plugin_version_prets() {
    return [
        'name'           => "Gestion de Prêts (Démo)",
        'version'        => '0.0.1',
        'author'         => 'Toi',
        'homepage'       => '',
        'minGlpiVersion' => '10.0.0'
    ];
}

function plugin_prets_check_prerequisites() {
    return true;
}

function plugin_prets_check_config($verbose = false) {
    return true;
}

function plugin_prets_install() {
    global $DB;

    $query = "CREATE TABLE IF NOT EXISTS glpi_plugin_prets_prets (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        date_start DATE,
        date_end DATE,
        status VARCHAR(50) DEFAULT 'Prêté',
        ticket INT UNSIGNED,
        users_id INT UNSIGNED,
        returned TINYINT(1) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $DB->query($query);

    return true;
}

function plugin_prets_uninstall() {
    global $DB;
    $DB->query("DROP TABLE IF EXISTS glpi_plugin_prets_prets;");
    return true;
}
