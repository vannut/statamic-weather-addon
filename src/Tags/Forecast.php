<?php

namespace Vannut\StatamicWeather\Tags;

use Vannut\StatamicWeather\Actions\CreateForecastDataAction;

class Forecast extends \Statamic\Tags\Tags
{   
    // {{ forecast locale="nl" }} {{ /forecast }}
    public function index(): array
    {
        $locale = strtolower($this->params->get('locale'));
        
        return (new CreateForecastDataAction)->execute($locale);
        
    }
}