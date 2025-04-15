<?php

class PluginPretsPret extends CommonDBTM {

    public static function getTypeName($nb = 0) {
        return _n('Prêt', 'Prêts', $nb, 'prets');
    }

    public function post_addItem() {
        Session::addMessageAfterRedirect('Prêt ajouté avec succès', true);
    }

}
