<?php

namespace Marwanosama8\SpatieActivitylogResources\Resources;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Activitylog\Models\Activity as ActivityModel;
use Marwanosama8\SpatieActivitylogResources\Resources\ActivityResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;

class ActivityResource extends Resource
{
    protected static ?string $label = 'Activity Loasdg';
    protected static ?string $slug = 'activity-logs';
    protected static ?string $navigationGroup = 'Admin';

    // protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Section::make([
                        TextInput::make('causer_id')
                            ->afterStateHydrated(function ($component, ?Model $record) {
                                /** @phpstan-ignore-next-line */
                                return $component->state($record->causer?->name);
                            })
                            ->label(__('filament-logger.resource.label.user')),

                        TextInput::make('subject_type')
                            ->afterStateHydrated(function ($component, ?Model $record, $state) {
                                /** @var Activity&ActivityModel $record */
                                return $state ? $component->state(Str::of($state)->afterLast('\\')->headline() . ' # ' . $record->subject_id) : '-';
                            })
                            ->label(__('filament-logger.resource.label.subject')),

                        Textarea::make('description')
                            ->label(__('filament-logger.resource.label.description'))
                            ->rows(2)
                            ->columnSpan('full'),
                    ])
                        ->columns(2),
                ])
                    ->columnSpan(['sm' => 3]),

                Group::make([
                    Section::make([
                        Placeholder::make('log_name')
                            ->content(function (?Model $record): string {
                                /** @var Activity&ActivityModel $record */
                                return $record->log_name ? ucwords($record->log_name) : '-';
                            })
                            ->label(__('filament-logger.resource.label.type')),

                        Placeholder::make('event')
                            ->content(function (?Model $record): string {
                                /** @phpstan-ignore-next-line */
                                return $record?->event ? ucwords($record?->event) : '-';
                            })
                            ->label(__('filament-logger.resource.label.event')),

                        Placeholder::make('created_at')
                            ->label(__('filament-logger.resource.label.logged_at'))
                            ->content(function (?Model $record): string {
                                /** @var Activity&ActivityModel $record */
                                return $record->created_at ? "{$record->created_at->format(config('spatie-activitylog-resources.datetime_format', 'd/m/Y H:i:s'))}" : '-';
                            }),
                    ])
                ]),
                Section::make()
                    ->columns()
                    ->visible(fn ($record) => $record->properties?->count() > 0)
                    ->schema(function (?Model $record) {
                        /** @var Activity&ActivityModel $record */
                        $properties = $record->properties->except(['attributes', 'old']);

                        $schema = [];

                        if ($properties->count()) {
                            $schema[] = KeyValue::make('properties')
                                ->label(__('filament-logger.resource.label.properties'))
                                ->columnSpan('full');
                        }

                        if ($old = $record->properties->get('old')) {
                            $schema[] = KeyValue::make('old')
                                ->afterStateHydrated(fn (KeyValue $component) => $component->state($old))
                                ->label(__('filament-logger.resource.label.old'));
                        }

                        if ($attributes = $record->properties->get('attributes')) {
                            $schema[] = KeyValue::make('attributes')
                                ->afterStateHydrated(fn (KeyValue $component) => $component->state($attributes))
                                ->label(__('filament-logger.resource.label.new'));
                        }

                        return $schema;
                    }),
            ])
            ->columns(['sm' => 4, 'lg' => null]);
    }

    public static function table(Table $table): Table
    {
        $users = User::all()->pluck('name', 'id');
        $users->prepend('All');
        
        return $table
            ->columns([
                TextColumn::make('log_name')
                    ->badge()
                    ->colors(static::getLogNameColors())
                    ->label(__('filament-logger.resource.label.type'))
                    ->formatStateUsing(fn ($state) => ucwords($state))
                    ->sortable(),

                TextColumn::make('event')
                    ->label(__('filament-logger.resource.label.event'))
                    ->sortable(),

                TextColumn::make('description')
                    ->label(__('filament-logger.resource.label.description'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->wrap(),

                TextColumn::make('subject_type')
                    ->label(__('filament-logger.resource.label.subject'))
                    ->formatStateUsing(function ($state, Model $record) {
                        /** @var Activity&ActivityModel $record */
                        if (!$state) {
                            return '-';
                        }
                        return Str::of($state)->afterLast('\\')->headline() . ' # ' . $record->subject_id;
                    }),

                TextColumn::make('causer.name')
                    ->label(__('filament-logger.resource.label.user')),

                TextColumn::make('created_at')
                    ->label(__('filament-logger.resource.label.logged_at'))
                    ->dateTime(config('spatie-activitylog-resources.datetime_format', 'd/m/Y H:i:s'))
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([])
            ->filters([
                Filter::make('causer')
                    ->form([
                        Select::make('causer_id')
                            ->label(__('filament-logger.resource.label.user'))
                            ->options($users)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['causer_id'], fn (Builder $query, $date): Builder => $query->where('causer_type', 'App\Models\User')->where('causer_id', $data['causer_id']));
                    }),
                SelectFilter::make('log_name')
                    ->label(__('filament-logger.resource.label.type'))
                    ->options(static::getLogNameList()),
                SelectFilter::make('subject_type')
                    ->label(__('filament-logger.resource.label.subject_type'))
                    ->options(static::getSubjectTypeList()),
                Filter::make('properties->old')
                    ->indicateUsing(function (array $data): ?string {
                        if (!$data['old']) {
                            return null;
                        }

                        return __('filament-logger.resource.label.old_attributes') . $data['old'];
                    })
                    ->form([
                        TextInput::make('old')
                            ->label(__('filament-logger.resource.label.old'))
                            ->hint(__('filament-logger.resource.label.properties_hint')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!$data['old']) {
                            return $query;
                        }

                        return $query->where('properties->old', 'like', "%{$data['old']}%");
                    }),

                Filter::make('properties->attributes')
                    ->indicateUsing(function (array $data): ?string {
                        if (!$data['new']) {
                            return null;
                        }

                        return __('filament-logger.resource.label.new_attributes') . $data['new'];
                    })
                    ->form([
                        TextInput::make('new')
                            ->label(__('filament-logger.resource.label.new'))
                            ->hint(__('filament-logger.resource.label.properties_hint')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!$data['new']) {
                            return $query;
                        }

                        return $query->where('properties->attributes', 'like', "%{$data['new']}%");
                    }),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('logged_at')
                            ->label(__('filament-logger.resource.label.logged_at'))
                            ->displayFormat(config('spatie-activitylog-resources.date_format', 'd/m/Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['logged_at'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', $date),
                            );
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'view' => Pages\ViewActivity::route('/{record}'),
        ];
    }

    public static function getModel(): string
    {
        return ActivitylogServiceProvider::determineActivityModel();
    }

    protected static function getSubjectTypeList(): array
    {
        if (config('spatie-activitylog-resources.resources.models', true)) {
            $subjects = [];
            $exceptResources = [...config('spatie-activitylog-resources.resources.exclude'), config('spatie-activitylog-resources.activity_resource')];
            $removedExcludedResources = collect(Filament::getResources())->filter(function ($resource) use ($exceptResources) {
                return !in_array($resource, $exceptResources);
            });
            foreach ($removedExcludedResources as $resource) {
                $model = $resource::getModel();
                $subjects[$model] = Str::of(class_basename($model))->headline();
            }
            return $subjects;
        }
        return [];
    }

    protected static function getLogNameList(): array
    {
        $customs = [];

        foreach (config('spatie-activitylog-resources.custom') ?? [] as $custom) {
            $customs[$custom['log_name']] = $custom['log_name'];
        }

        return array_merge(
            config('spatie-activitylog-resources.resources.enabled') ? [
                config('spatie-activitylog-resources.resources.log_name') => config('spatie-activitylog-resources.resources.log_name'),
            ] : [],
            config('spatie-activitylog-resources.models.enabled') ? [
                config('spatie-activitylog-resources.models.log_name') => config('spatie-activitylog-resources.models.log_name'),
            ] : [],
            config('spatie-activitylog-resources.access.enabled')
                ? [config('spatie-activitylog-resources.access.log_name') => config('spatie-activitylog-resources.access.log_name')]
                : [],
            config('spatie-activitylog-resources.notifications.enabled') ? [
                config('spatie-activitylog-resources.notifications.log_name') => config('spatie-activitylog-resources.notifications.log_name'),
            ] : [],
            $customs,
        );
    }

    protected static function getLogNameColors(): array
    {
        $customs = [];

        foreach (config('spatie-activitylog-resources.custom') ?? [] as $custom) {
            if (filled($custom['color'] ?? null)) {
                $customs[$custom['color']] = $custom['log_name'];
            }
        }

        return array_merge(
            (config('spatie-activitylog-resources.resources.enabled') && config('spatie-activitylog-resources.resources.color')) ? [
                config('spatie-activitylog-resources.resources.color') => config('spatie-activitylog-resources.resources.log_name'),
            ] : [],
            (config('spatie-activitylog-resources.models.enabled') && config('spatie-activitylog-resources.models.color')) ? [
                config('spatie-activitylog-resources.models.color') => config('spatie-activitylog-resources.models.log_name'),
            ] : [],
            (config('spatie-activitylog-resources.access.enabled') && config('spatie-activitylog-resources.access.color')) ? [
                config('spatie-activitylog-resources.access.color') => config('spatie-activitylog-resources.access.log_name'),
            ] : [],
            (config('spatie-activitylog-resources.notifications.enabled') &&  config('spatie-activitylog-resources.notifications.color')) ? [
                config('spatie-activitylog-resources.notifications.color') => config('spatie-activitylog-resources.notifications.log_name'),
            ] : [],
            $customs,
        );
    }

    public static function getLabel(): string
    {
        return __('filament-logger.resource.label.log');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-logger.resource.label.logs');
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Admin';
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-logger.nav.log.label');
    }

    public static function getNavigationIcon(): string
    {
        return __('filament-logger.nav.log.icon');
    }
}
