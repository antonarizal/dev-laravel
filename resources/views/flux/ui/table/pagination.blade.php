@props(['results'=>[]])

<div class="p-3">
    {{ $results->onEachSide(1)->links() }}
</div>
