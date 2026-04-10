<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<div class="container">
    <div class="row">
        <form id="form-validation-2" class="form" action="{{ route('productinsert') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-12 mt-3">
                <h4 class="card-title mt-0 mb-2" style="font-size: 25px; font-family: 'Pacifico' !important; display: inline-block; color:#115e0f; border:1px solid #115e0f; background-color:#fff; border-radius:10px; padding:20px;">
                    Product Details
                </h4>

                    <div class="row" data-index="0">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-2 col-md-4">
                                            <label for="productname" class="mb-2">Product Name</label>
                                            <span style="color:red;">*</span>
                                            <input class="form-control" type="text" id="productname" name="productname">
                                        </div>
                                        


                                        <div class="mb-2 col-md-4">
                                            <label for="category" class="mb-2">Product Category</label>
                                            <span style="color:red;">*</span>
                                             <input class="form-control" type="text" id="productCategory" name="productCategory">
                                        </div>


                                        <div class="mb-2 col-md-4">
                                            <label for="category" class="mb-2">Batch No.</label>
                                            <span style="color:red;">*</span>
                                            <input class="form-control" type="text" id="Batchno" name="Batchno">
                                           
                                        </div>
                                        
                                        

                                        
                                        <div class="mb-2 col-md-4">
                                            <label for="quantity" class="mb-2"> Boxes / single products</label>
                                            <input class="form-control" type="text" id="quantity" name="quantity" 
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')" placeholder="e.g. 20">
                                        </div>
                                        
                                        <div class="mb-2 col-md-4">
                                            <label for="measurement" class="mb-2">Unit Of Measurement</label>
                                            
                                                 <select class="form-control" id="measurement" name="measurement" >
                                                <option class="text-center">---Select Measurement Category----</option>
                                                <!--@foreach ($productcate as $item)-->
                                                <!--    @if($item->type === 'measurement') <!-- Adjust this condition based on how you identify vehicle categories -->-->
                                                <!--        <option value="{{ $item->value }}">{{ $item->value }}</option>-->
                                                <!--    @endif-->
                                                <!--@endforeach-->
                                                 
                                                <option value="PCS">PCS</option>
                                                 <option value="boxes">boxes</option>
                                            </select>
                                                
                                        </div>
                                        
                                        <div class="mb-2 col-md-4">
                                            <label for="box" class="mb-2">Total Box Qty</label>
                                            <input class="form-control" type="text" id="box" name="box" placeholder="e.g. 1">
                                        </div>
                                        
                                         <div class="mb-2 col-md-4">
                                            <label for="box" class="mb-2">per box quantity </label>
                                            <input class="form-control" type="text" id="box" name="box" placeholder="e.g. 1">
                                        </div>

                                        <div class="mb-2 col-md-4">
                                            <label for="productprice" class="mb-2">Product HSN Code</label>
                                              <span style="color:red;">*</span>
                                            <input class="form-control" type="text" id="hsncode" name="hsncode">
                                        </div>

                                        <div class="mb-2 col-md-4">
                                            <label for="file" class="mb-2">Product File</label>
                                            <span style="color:red;">*</span>
                                            <input class="form-control" type="file" name="file" multiple>
                                        </div>
                                    
                                        <div class="mb-2 col-md-4" style="display: none;">
                                            <label for="image" class="mb-2">Product Multiple Image</label>
                                            <input class="form-control" type="file" name="image[]" multiple>
                                        </div>

                                        
                                        <div class="mb-2 col-md-12" style="display: none;">
                                            <label for="productname" class="mb-2">Link</label>
                                            <input class="form-control" type="text" id="link" name="link">
                                        </div>
                                       

                                        <div class="mb-2 col-md-12" style="display: none;">
                                            <label for="productname" class="mb-2">Meta Tag Title</label>
                                            <input class="form-control" type="text" id="metatag" name="metatag">
                                        </div>
                                       
                                        <div class="mb-2 col-md-12" style="display: none;">
                                            <label for="productname" class="mb-2">Action</label>
                                            <input class="form-control" type="text" id="action" name="action" value="1">
                                        </div>

                                        <div class="mb-2 col-md-12" style="display: none;">
                                            <label for="productprice" class="mb-2">Meta Tag Description</label>
                                       <textarea class="form-control" type="text" id="metadescription" name="metadescription"></textarea>
                                        </div>


                                        <div class="mb-2 col-md-12" style="display: none;">
                                            <label for="productprice" class="mb-2">Meta Tag Keywords</label>
                                       <textarea class="form-control" type="text" id="metakeyword" name="metakeyword"></textarea>
                                                                                  
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <label for="description" class="mb-2">Description</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                            
                                        </div>


                                           {{-- price tables --}}
        

                                            <div class="row" data-index="0">
                                            <h4 class="card-title mt-0 mb-2" style="font-size: 25px; font-family: 'Pacifico' !important; display: inline-block; color:#115e0f; background-color:#fff; border-radius:10px; padding:20px;">
                                                Product Price
                                            </h4>
                                                                    
                                                                                
                                                                        
                                                @foreach ($userrole as $index => $roledata)
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <span style="color:red;">*</span>
                                                        <input type="hidden" name="role[]" value="{{$roledata->id}}"/>
                                                        <span>{{$roledata->role}}</span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control productprice" type="text" id="productprice_{{$index}}" 
                                                        name="price[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" 
                                                        placeholder="e.g. 200">
                                                    </div>
                                                    <div class="mb-2 col-md-4">
                                                        <input class="form-control totalbox" type="text" id="totalbox_{{$index}}" name="totalprice[]" placeholder="00.0" readonly>
                                                    </div>
                                                </div>
                                            @endforeach
                                      
                                         <div class="col-md-12 mt-3 text-end">
                                            <input type="submit" style="font-size:18px; border-radius:10px;" class="btn btn-success" value="Submit" />
                                         </div>
                                    </div>
                                </div><!-- end card-body -->
                            </div>
                        </div>
                    </div>

                
         

                
            </div>
</div>
        
        </form><!-- end form -->


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                function calculateTotalBox(index) {
                    let price = document.getElementById(`productprice_${index}`).value;
                    let perqty = document.getElementById('quantity')?.value || 0;
                    let measurement = document.getElementById('measurement')?.value;
                    let totalbox = document.getElementById(`totalbox_${index}`);
                    let perbox = document.getElementById('box')?.value || 0;
        
                    price = parseFloat(price) || 0;
                    perqty = parseFloat(perqty) || 0;
                    perbox = parseFloat(perbox) || 0;
        
                    if (measurement !== 'BKT' && measurement !== 'Ltr') {
                        totalbox.value = (price * perqty).toFixed(2);
                    } else {
                        totalbox.value = (perbox * price).toFixed(2);
                    }
                }
        
                function attachEventListeners() {
                    document.querySelectorAll('.productprice').forEach((input) => {
                        let index = input.id.split('_')[1]; // Extract index from ID
                        input.addEventListener('input', () => calculateTotalBox(index));
                    });
        
                    ['quantity', 'measurement', 'box'].forEach(id => {
                        let element = document.getElementById(id);
                        if (element) {
                            element.addEventListener('input', () => {
                                document.querySelectorAll('.productprice').forEach(input => {
                                    let index = input.id.split('_')[1];
                                    calculateTotalBox(index);
                                });
                            });
                        }
                    });
                }
        
                attachEventListeners();
            });
        </script>