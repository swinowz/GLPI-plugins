<?php

class PluginPretsMenu extends CommonGLPI {

    static function getMenuName() {
        return __('Gestion de Prêts', 'prets');
    }

    static function getMenuContent() {
        return [
            'title' => self::getMenuName(),
            'page'  => '/plugins/prets/front/index.php'
        ];
    }
}
