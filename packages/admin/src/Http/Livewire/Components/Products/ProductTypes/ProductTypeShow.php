<?php

namespace GetCandy\Hub\Http\Livewire\Components\Products\ProductTypes;

use GetCandy\Models\Attribute;
use GetCandy\Models\Product;
use GetCandy\Models\ProductType;
use GetCandy\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductTypeShow extends AbstractProductType
{
    /**
     * Attributes which are ready to be synced.
     *
     * @var array
     */
    public array $attributes = [];

    public bool $deleteDialogVisible = false;

    public function mount()
    {
        $systemProductAttributes = Attribute::system(Product::class)->get();
        $systemVariantAttribues = Attribute::system(ProductVariant::class)->get();
        $this->selectedProductAttributes = $this->productType->mappedAttributes
            ->filter(fn ($att) => $att->attribute_type == Product::class)
            ->merge($systemProductAttributes);

        $this->selectedVariantAttributes = $this->productType->mappedAttributes
            ->filter(fn ($att) => $att->attribute_type == ProductVariant::class)
            ->merge($systemVariantAttribues);
    }

    /**
     * Register the validation rules.
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'productType.name' => [
                'required',
                'string',
                'unique:'.$this->productType->getTable().',name,'.$this->productType->id,
            ],
        ];
    }

    /**
     * Method to handle product type saving.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $this->productType->save();

        $this->productType->mappedAttributes()->sync(
            array_merge(
                $this->selectedProductAttributes->pluck('id')->toArray(),
                $this->selectedVariantAttributes->pluck('id')->toArray()
            )
        );

        $this->notify(
            __('adminhub::catalogue.product-types.show.updated_message'),
            'hub.product-types.index'
        );
    }

    public function getCanDeleteProperty()
    {
        return ! $this->isTheOnlyProductType && ! $this->productType->products()->count();
    }

    /**
     * Returns whether this is the only Product type in the system.
     *
     * @return bool
     */
    public function getIsTheOnlyProductTypeProperty()
    {
        return ProductType::count() == 1;
    }

    /**
     * Delete the variant.
     *
     * @return void
     */
    public function delete()
    {
        if (! $this->canDelete) {
            $this->notify(
                __('adminhub::catalogue.product-types.show.delete.disabled_message')
            );
            $this->deleteDialogVisible = false;

            return;
        }

        DB::transaction(fn () => $this->productType->delete());

        $this->notify(
            __('adminhub::catalogue.product-types.show.delete.delete_notification'),
            'hub.product-types.index'
        );
    }

    /**
     * Render the livewire component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('adminhub::livewire.components.products.product-types.show')
            ->layout('adminhub::layouts.base');
    }
}
