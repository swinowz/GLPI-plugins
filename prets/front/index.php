    <?php
    include('../../../inc/includes.php');
    require_once(__DIR__ . '/../inc/prets.class.php');

    // Marquer comme retourné
    if (isset($_GET['return'])) {
        $id = (int)$_GET['return'];
        $pret = new PluginPretsPret();
        if ($pret->getFromDB($id)) {
            $pret->update([
                'id'       => $id,
                'returned' => 1,
                'status'   => 'Rendu'
            ]);
            Session::addMessageAfterRedirect("Prêt #$id marqué comme rendu", true);
            Html::redirect('index.php');
        }
    }



    Html::header("Liste des prêts", $_SERVER['PHP_SELF'], "admin", "pluginprets");

    $pret = new PluginPretsPret();
    $iterator = $pret->find(['returned' => 0]);

    echo "<div class='center' style='margin: 20px 0;'>";
    echo "<a class='vsubmit' href='returned.php' style='margin-right: 10px;'>Historique</a>";
    echo "<a class='vsubmit' href='form.php'>Nouveau prêt</a>";
    echo "</div>";
    


    echo "<table class='tab_cadre_fixe'>";
    echo "<tr><th>Nom</th><th>Date début</th><th>Date fin</th><th>Ticket</th><th>Utilisateur</th><th>Statut</th><th>Action</th></tr>";

    foreach ($iterator as $data) {
        echo "<tr>";
        echo "<td>" . $data['name'] . "</td>";
        echo "<td>" . $data['date_start'] . "</td>";
        echo "<td>" . $data['date_end'] . "</td>";
    
        // Ticket lié
        if (!empty($data['ticket'])) {
            echo "<td><a href='/front/ticket.form.php?id=" . $data['ticket'] . "' target='_blank'>Ticket #" . $data['ticket'] . "</a></td>";
        } else {
            echo "<td>-</td>";
        }
    
        // Utilisateur
        if (!empty($data['users_id'])) {
            $user = new User();
            if ($user->getFromDB($data['users_id'])) {
                echo "<td>" . $user->getName() . "</td>";
            } else {
                echo "<td><i>Inconnu</i></td>";
            }
        } else {
            echo "<td>-</td>";
        }
    
        // Statut avec couleur
        $today = strtotime(date('Y-m-d'));
        $end = strtotime($data['date_end']);
        $diff = ($end - $today) / 86400;
    
        $color = 'green';
        if (!$data['returned']) {
            if ($end < $today) {
                $color = 'red';
            } elseif ($diff <= 3) {
                $color = 'orange';
            }
        }
    
        echo "<td><span style='color:$color'><strong>{$data['status']}</strong></span></td>";
    
        // Action
        if ($data['returned']) {
            echo "<td>-</td>";
        } else {
            echo "<td><a class='vsubmit' href='index.php?return={$data['id']}'>Retourné</a></td>";
        }
    
        echo "</tr>";
    }
    


    echo "</table>";

    Html::footer();
