<?php
include('../../../inc/includes.php');
require_once(__DIR__ . '/../inc/prets.class.php');


$pret = new PluginPretsPret();

if (isset($_POST['add'])) {
    $pret->add([
        'name'       => $_POST['name'],
        'date_start' => $_POST['date_start'],
        'date_end'   => $_POST['date_end'],
        'ticket'     => $_POST['ticket'],
        'users_id'   => $_POST['users_id'],
        'status'     => 'Prêté',
        'returned'   => 0
    ]);
    Html::redirect('index.php');
}

Html::header("Nouveau Prêt", $_SERVER['PHP_SELF'], "admin", "pluginprets");

echo "<form method='post' action=''>";
echo Html::hidden('_glpi_csrf_token', ['value' => Session::getNewCSRFToken()]);

echo "<table class='tab_cadre_fixe'>";
echo "<tr><th colspan='2'>Faire un prêt</th></tr>";

echo "<tr><td>Objet</td><td><input type='text' name='name' required></td></tr>";
echo "<tr><td>Date début</td><td><input type='date' name='date_start' required></td></tr>";
echo "<tr><td>Date fin</td><td><input type='date' name='date_end' required></td></tr>";





echo "<tr><td>Ticket lié</td><td>";
echo "<select name='ticket' id='ticket-select' style='width: 300px;'></select>";
echo "</td></tr>";
echo "<script>
$('#ticket-select').select2({
    placeholder: 'Choisir un ticket',
    ajax: {
        url: '../ajax/tickets.php',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                searchText: params.term
            };
        },
        processResults: function (data) {
            return {
                results: data.results.map(t => ({ id: t.id, text: t.label }))
            };
        }
    }
});
$(document).on('select2:open', () => {
   document.querySelector('.select2-container--open .select2-search__field').focus();
});

</script>";




echo "<tr><td>Utilisateur</td><td>";
echo "<select name='users_id' id='users_id_select' style='width: 300px;'></select>";  
echo "<script>
$('#users_id_select').select2({
    placeholder: 'Choisir un utilisateur',
    ajax: {
        url: '../ajax/users.php',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                searchText: params.term
            };
        },
        processResults: function (data) {
            return {
                results: data.results.map(u => ({ id: u.id, text: u.label }))
            };
        }
    }
});
$(document).on('select2:open', () => {
   document.querySelector('.select2-container--open .select2-search__field').focus();
});

</script>";
echo "</td></tr>";





echo "<tr><td colspan='2' class='center'>";
echo "<button type='submit' name='add' class='vsubmit'>Créer</button>";
echo "</td></tr>";
echo "</table>";
echo "</form>";


Html::footer();