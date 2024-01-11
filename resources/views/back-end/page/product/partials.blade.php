<!-- File partials.blade.php -->
<div style="margin-left: {{ $depth * 20 }}px;">
    @if ($category->parent_id == 0)
        <input type="checkbox" name="category_id[]" value="{{ $category->id }}"> {{ $category->name }} <br>
    @else
        <div class="row">
            <div class="col-3">
                <input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                    onclick="data(this, '{{ $category->id }}', 'texts_{{ $category->id }}')">
                {{ $category->name }} <br>
            </div>
            <div class="col-6">
                <span id="texts_{{ $category->id }}">

                </span>
            </div>
        </div>
    @endif
    @if ($category->children->isNotEmpty())
        @foreach ($category->children as $child)
            @include('back-end.page.product.partials', [
                'category' => $child,
                'depth' => $depth + 1,
            ])
        @endforeach
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function data(checkbox, categoryId, elementId) {
        var Content = document.getElementById(elementId);
        if (checkbox.checked) {
            $('.kk input[name="is_primary"]').remove();



            Content.innerHTML = '<button class="kk" type="button"><input id="is_primary_' + categoryId +
                '" type="text" name="is_primary" value="' + categoryId + '">Đặt làm mặc định</button>';
            $('.kk').on('click', function() {
                hiddenButton();


            });


        } else {
            Content.innerHTML = '';

        }
    }

    function hiddenButton() {
        $('.kk').hide();
    }
</script>



