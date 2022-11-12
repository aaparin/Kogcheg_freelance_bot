<?php

namespace App\Orchid\Layouts;

use App\Models\Services;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServicesLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'services';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),
            TD::make('name', 'Название')
                ->sort()
                ->render(function (Services $service) {
                    return Link::make($service->name)
                        ->route('platform.services.edit', $service);
                }),
            TD::make('parent_id', 'Родитель')
                ->filter(Input::make())
                ->render(function ($service) {
                    return $service->getName($service->parent_id);
                }),
            TD::make('sort', 'Sort')
                ->sort(),
            TD::make()
                ->width('100px')
                ->align(TD::ALIGN_RIGHT)
                ->render(function ($service) {
                    return Group::make([
                        Link::make('Редактировать')->icon('pencil')->route('platform.services.edit', $service),
//                        Link::make('Удалить')
//                            ->icon('trash')
//                            ->confirm('Точно удалить?')
//                            ->method('remove', [
//                                'id' => $service->id,
//                            ])
                    ]);
                })
//            TD::make('created_at', 'Создано'),
//            TD::make('updated_at', 'Изменено'),
        ];
    }
}
