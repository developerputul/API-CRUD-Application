@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Edit Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

  <div class="card">
      <div class="card-body p-4">
          <h5 class="card-title">Edit Product</h5>
          <hr/>

          <form id="myForm" method="POST" action="{{ route('update.product') }}">
            @csrf

          <input type="hidden" name="id" value="{{ $products->id }}">

           <div class="form-body mt-4">
            <div class="row">
               <div class="col-lg-8">
                <div class="border border-3 p-4 rounded">

                <div class="form-group mb-3">
                    <label for="inputProductTitle" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="inputProductTitle" value="{{ $products->product_name }}">
                </div>

                <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Short Description</label>
                    <textarea name="short_desc" class="form-control" id="inputProductDescription" rows="3">
                       {{ $products->short_desc }}
                    </textarea>
                </div>
                </div>
               </div>

               <div class="col-lg-4">
                <div class="border border-3 p-4 rounded">
                  <div class="row g-3">

                    <div class="form-group col-md-6">
                        <label for="inputPrice" class="form-label">Selling Price</label>
                        <input type="text" name="selling_price" class="form-control" id="inputPrice"value="{{ $products->selling_price }}">
                      </div>

                      <div class="col-md-6">
                        <label for="inputCompareatprice" class="form-label">Discount Price</label>
                        <input type="text" name="discount_price" class="form-control" id="inputCompareatprice" value="{{ $products->discount_price }}">
                      </div>


                      <div class="form-group col-12">
                        <label for="inputVendor" class="form-label">Product Category</label>
                        <select name="category_id" class="form-select" id="inputVendor">
                            
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $products->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                          @endforeach
                          </select>
                      </div>

                      <div class="col-12">
                        <label for="inputCollection" class="form-label">Product SubCategory</label>
                        <select name="subcategory_id" class="form-select" id="inputCollection">
                            
                            @foreach ($subcategory as $subcat)
                            <option value="{{ $subcat->id }}" {{ $subcat->id == $products->subcategory_id ? 'selected' : '' }}>{{ $subcat->subcategory_name}}</option>
                          @endforeach
                          </select>
                      </div>


                      <hr>  
                      <div class="col-12">
                          <div class="d-grid">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                          </div>
                      </div>
                  </div> 
              </div>
              </div>
           </div><!--end row-->
        </div>
      </div>
    </form>
  </div>
</div>


 {{-- Main Image Thambnail Update --}}
 <div class="page-content">
  <h6 class="mb-0 text-uppercase">Update Main Image Thambnail</h6>
  <br>

  <div class="card">
    <form method="POST" action="{{ route('update.product.thambnail') }}" enctype="multipart/form-data">
      @csrf

      <input type="hidden" name="id" value="{{ $products->id }}">
      <input type="hidden" name="old_img" value="{{ $products->product_thambnail }}">

    <div class="card-body">

      <div class="mb-3">
        <label for="formFile" class="form-label">Chose Thambnail Image</label>
        <input name="product_thambnail" class="form-control" type="file" id="formFile">
      </div>

      <div class="mb-3">
        <label for="formFile" class="form-label"></label>
        <img src="{{ asset($products->product_thambnail) }}" style="width: 100px; height:100px;">
      </div>
      <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
     </div>

    </form>
  </div>
</div>
{{--End Main Image Thambnail Update --}}
 




<script type="text/javascript">
  $(document).ready(function() {
      $('#myForm').validate({
          rules: {
              product_name: {
                  required: true,
              },
              short_desc: {
                  required: true,
              },
              product_thambnail: {
                  required: true,
              },
              multi_img: {
                  required: true,
              },
              selling_price: {
                  required: true,
              },
              product_code: {
                  required: true,
              },
              product_qty: {
                  required: true,
              },
              brand_id: {
                  required: true,
              },
              category_id: {
                  required: true,
              },
              subcategory_id: {
                  required: true,
              },
             
          },
          messages: {
            product_name: {
                  required: 'Please Enter Product Name',
              },
              short_desc: {
                  required: 'Please Enter Short Description',
              },
              product_thambnail: {
                  required: 'Please Select Product Thambnail Image',
              },
              multi_img: {
                  required: 'Please Select Product Multi Image',
              },
              selling_price: {
                  required: 'Please Enter Selling Price',
              },
              product_code: {
                  required: 'Please Enter Product Code',
              },
              product_qty: {
                  required: 'Please Enter Product Quantity',
              },
          },
          errorElement: 'span',
          errorPlacement: function(error, element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
          },
          highlight: function(element, errorClass, validClass) {
              $(element).addClass('is-invalid');
          },
          unhighlight: function(element, errorClass, validClass) {
              $(element).removeClass('is-invalid');
          },
      });
  });
</script>


<script type="text/javascript">
	function mainThamUrl(input){
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e){
				$('#mainThmb').attr('src',e.target.result).width(80).height(80);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>



<script type="text/javascript">
  $(document).ready(function(){
    $('select[name="category_id"]').on('change', function(){
      var category_id = $(this).val();
      if (category_id) {
        $.ajax({
          url: "{{ url('/subcategory/ajax') }}/"+category_id,
          type: "GET",
          dataType:"json",
          success:function(data){
            $('select[name="subcategory_id"]').html('');
            var d =$('select[name="subcategory_id"]').empty();
            $.each(data, function(key, value){
              $('select[name="subcategory_id"]').append('<option value="'+ value.id + '">' + value.subcategory_name + '</option>');
            });
          },
        });
      } else {
        alert('danger');
      }
    });
  });
</script>


@endsection