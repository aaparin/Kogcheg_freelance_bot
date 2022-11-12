<?php

namespace App\Orchid\Resources;

use App\Models\Places;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\TD;
use App\Models\Services;
use Orchid\Support\Facades\Layout;

class ServiceResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */

    public static $model = Services::class;


    public static function label(): string
    {
        return 'Услуги';
    }

    public static function createButtonLabel(): string
    {
        return 'Добавить';
    }

    public static function icon(): string
    {
        return 'directions';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [

            Input::make('name')
                ->title('Название')
                ->placeholder('Название услуги'),
            Input::make('sort')
                ->type('number')
                ->title('Сортировка'),
            CheckBox::make('user_show')
                ->sendTrueOrFalse(true)
                ->title('Показывать пользователю')
                ->placeholder('Да'),

            Relation::make('parent_id')
                ->title('Родительский раздел')
                ->fromModel(Services::class, 'name')

        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
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
                ->filter(
                    Relation::make('parent_id')
                        ->title('Родительский раздел')
                        ->fromModel(Services::class, 'name')
                )
                ->render(function ($service) {
                    return $service->getName($service->parent_id);
                }),
            TD::make('command', 'Команда запуска')
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            new DefaultSorted('sort', 'asc'),
        ];
    }

    public function onSave(ResourceRequest $request, Model $model)
    {
        /**
         * Hack for zero structure
         */
        $dataArray = $request->all();
        if (is_null($dataArray['parent_id'])) {
            $dataArray['parent_id'] = 0;
        }
        $model->forceFill($dataArray)->save();
    }
}
