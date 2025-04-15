<?php
include('../../../inc/includes.php');
require_once(__DIR__ . '/../inc/prets.class.php');

Html::header("Prêts rendus", $_SERVER['PHP_SELF'], "admin", "pluginprets");

$pret = new PluginPretsPret();
$iterator = $pret->find(['returned' => 1]);

echo "<div class='center' style='margin: 20px 0;'>";
echo "<a class='vsubmit' href='index.php' style='margin-right: 10px;'>Retour</a>";
echo "<a class='vsubmit' href='form.php'>Nouveau prêt</a>";
echo "</div>";

echo "<table class='tab_cadre_fixe'>";
echo "<tr><th>Nom</th><th>Date début</th><th>Date fin</th><th>Utilisateur</th><th>Ticket</th><th>Statut</th></tr>";

foreach ($iterator as $data) {
    echo "<tr>";
    echo "<td>" . $data['name'] . "</td>";
    echo "<td>" . $data['date_start'] . "</td>";
    echo "<td>" . $data['date_end'] . "</td>";

    // Utilisateur
    if (!empty($data['users_id'])) {
        $user = new User();
        $user->getFromDB($data['users_id']);
        echo "<td>" . $user->getName() . "</td>";
    } else {
        echo "<td>-</td>";
    }

    // Ticket
    if (!empty($data['ticket'])) {
        echo "<td><a href='/front/ticket.form.php?id={$data['ticket']}'>Ticket #{$data['ticket']}</a></td>";
    } else {
        echo "<td>-</td>";
    }

    echo "<td><span style='color:green'><strong>{$data['status']}</strong></span></td>";
    echo "</tr>";
}

echo "</table>";
Html::footer();
