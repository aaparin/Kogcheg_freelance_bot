<?php

namespace App\Orchid\Resources;

use App\Models\Places;
use App\Models\ServicesModel;
use App\Orchid\Filters\PlacesFilter;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\TD;

class PlacesResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Places::class;

    public static function label(): string
    {
        return 'Местоположения';
    }

    public static function createButtonLabel(): string
    {
        return 'Добавить';
    }

    public static function icon(): string
    {
        return 'globe';
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
                ->title('Название места')
                ->required(),
            Input::make('sort')
                ->title('Сортировка')
                ->type('number')
                ->value(0)
                ->required(),
            Relation::make('parent_id')
                ->title('Родительский раздел')
                ->fromModel(Places::class, 'name')
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
            TD::make('id')->sort(),
            TD::make('name', 'Название')->sort()->cantHide(),
            TD::make('sort', 'Сортировка')->sort(),
            TD::make('parent_id', 'Родитель')
                ->filter(
                    Relation::make('parent_id')
                        ->title('Родительский раздел')
                        ->fromModel(Places::class, 'name')
                )
                ->render(function ($model) {
                    return $model->getName($model->parent_id);
                }),
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
            // PlacesFilter::class,
            //new DefaultSorted('id', 'asc')
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
