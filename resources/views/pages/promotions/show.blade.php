<x-layout>
    <div class="row" style="{height: 800px}">
        <div class="col-1"></div>
        <div class="col-10">
            <x-app.promotions.products-list.card :promotion="$promotion" />
        </div>
        <div class="col-1"></div>
    </div>
</x-layout>
