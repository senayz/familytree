<div id="tree-container" class="w-full flex justify-center">
    <ul class="tree">
        @foreach($founders as $founder)
            @include('partials.family-member', ['member' => $founder])
        @endforeach
    </ul>
</div>

@push('styles')
<style>
    #tree-container {
        overflow-x: auto;
        padding-bottom: 40px;
    }
    /* Simple centering for the tree root */
    .tree {
        display: inline-block;
        white-space: nowrap;
        margin: 0 auto;
    }
</style>
@endpush