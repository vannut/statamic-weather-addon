<?php

namespace Vannut\StatamicWeather\Widgets;

use Statamic\Widgets\Widget;
use Vannut\StatamicWeather\Actions\CreateForecastDataAction;

class CurrentForecast extends Widget
{

    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        $forecast=(new CreateForecastDataAction())->execute();

        return view('weather::widgets.forecast',['forecast'=>$forecast]);
    }
}