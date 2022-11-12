<?php

namespace App\Orchid\Screens;

use App\Models\Services;
use App\Orchid\Layouts\ServicesLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ServicesScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'services' => Services::paginate(),
            'service' => Services::find(1)
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Услуги';
    }

    public function description(): ?string
    {
        return "Тут ведем иерархию услуг";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Link::make('Добавить')
                ->icon('pencil')
                ->route('platform.services.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ServicesLayout::class
        ];
    }
}
