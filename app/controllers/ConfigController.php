<?php

class ConfigController extends BaseController {
    public function getConfig ()
    {
        return ['sources' => Config::get('manifest.sources'),
            'styles'  => Config::get('manifest.styles'),
            'widgets' => [
                'commenter' => (string) View::make('comments')
            ]
        ];
    }

}
