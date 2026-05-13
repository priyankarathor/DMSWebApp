<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<div class="container mt-4">
    <div class="row">
        <form class="form" action="{{ url('/productdataedit/' . $productedit->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="col-lg-12">
                <div class="card shadow-sm">

                    <div class="card-header">
                        <h4 class="card-title mb-0" style="color:#115e0f;">
                            Edit Product Details
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-4">
                                <label class="mb-2">Product Name</label>
                                <input class="form-control" type="text" name="productname" value="{{ $productedit->productname }}">
                            </div>

                         


                            <div class="mb-3 col-md-4">
                                <label class="mb-2">Brand</label>
                                <input class="form-control" type="text" name="brand" value="{{ $productedit->brand }}">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="mb-2">Per Box PCS Quantity</label>
                                <input class="form-control" type="text" id="quantity" name="quantity" value="{{ $productedit->quantity }}">
                            </div>                            

                            <div class="mb-3 col-md-4">
                                <label class="mb-2">Weight Number</label>
                                <input class="form-control" type="text" name="weightnum" value="{{ $productedit->weightnum }}">
                            </div>


                            <div class="mb-3 col-md-4">
                                <label class="mb-2">HSN Code</label>
                                <input class="form-control" type="text" name="hsncode" value="{{ $productedit->hsncode }}">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="mb-2">DP</label>
                                <input class="form-control" type="text" name="dp" value="{{ $productedit->dp }}">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="mb-2">MOP</label>
                                <input class="form-control" type="text" name="mop" value="{{ $productedit->mop }}">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="mb-2">MRP</label>
                                <input class="form-control" type="text" name="mrp" value="{{ $productedit->mrp }}">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="mb-2">Product Price</label>
                                <input class="form-control" type="text" name="productprice" value="{{ $productedit->productprice }}">
                            </div>

                     
                            <div class="mb-3 col-md-4">
                                <label class="mb-2">Status</label>
                                <select class="form-control" name="action">
                                    <option value="Active" {{ $productedit->Action == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Disable" {{ $productedit->Action == 'Disable' ? 'selected' : '' }}>Disable</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="mb-2">Product Main File/Image</label>
                                <input class="form-control" type="file" name="file">

                                @if($productedit->file)
                                    <div class="mt-2">
                                        <img src="{{ asset('image/' . $productedit->file) }}" width="90" height="90" style="object-fit:cover; border-radius:8px;">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="mb-2">Product Multiple Images</label>
                                <input class="form-control" type="file" name="image[]" multiple>

                                @if($productedit->image)
                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        @foreach(explode(',', $productedit->image) as $img)
                                            @if($img)
                                                <img src="{{ asset($img) }}" width="80" height="80" style="object-fit:cover; border-radius:8px;">
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <input type="hidden" name="link" value="{{ $productedit->link }}">
                            <input type="hidden" name="metatag" value="{{ $productedit->metatag }}">
                            <input type="hidden" name="metadescription" value="{{ $productedit->metadescription }}">
                            <input type="hidden" name="metakeyword" value="{{ $productedit->metakeyword }}">

                            <div class="col-md-12 mt-2">
                                <label class="mb-2">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ $productedit->description }}</textarea>
                            </div>

                            
                        <div class="text-end mt-4">
                            <a href="{{ url('productlist') }}" class="btn btn-outline-secondary">
                                Back
                            </a>

                            <button type="submit" class="btn btn-success">
                                Update Product
                            </button>
                        </div>

                        </div>
                    </div>
                </div>

                
            </div>
        </form>
    </div>
</div>

<script>
    if (document.getElementById('description')) {
        CKEDITOR.replace('description');
    }

    document.addEventListener("DOMContentLoaded", function () {
        function calculateTotalBox(index) {
            let price = parseFloat(document.getElementById(`productprice_${index}`)?.value) || 0;
            let perqty = parseFloat(document.getElementById('quantity')?.value) || 0;
            let measurement = document.getElementById('measurement')?.value;
            let totalbox = document.getElementById(`totalbox_${index}`);
            let boxquantity = parseFloat(document.getElementById('boxquantity')?.value) || 0;

            if (!totalbox) return;

            if (measurement === 'BKT' || measurement === 'Ltr') {
                totalbox.value = (boxquantity * price).toFixed(2);
            } else {
                totalbox.value = (price * perqty).toFixed(2);
            }
        }

        function calculateAll() {
            document.querySelectorAll('.productprice').forEach(input => {
                let index = input.id.split('_')[1];
                calculateTotalBox(index);
            });
        }

        document.querySelectorAll('.productprice').forEach(input => {
            input.addEventListener('input', calculateAll);
        });

        ['quantity', 'measurement', 'boxquantity'].forEach(id => {
            let element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', calculateAll);
                element.addEventListener('change', calculateAll);
            }
        });

        calculateAll();
    });
</script>