@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
    <h1>Products</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
           @if(Session::has('flash_message_success'))
             <div class="alert alert-success alert-block">
	         <button type="button" class="close" data-dismiss="alert">×</button>	
           <strong>{{ session('flash_message_success') }}</strong>
          </div>
            @endif
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Products</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Category ID</th>
                    <th>Category Name</th>
                  <th>Product Name</th>
                    <th>Product Code</th>
                    <th>Product Color</th>
                    <th>Price</th>
                    <th>Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach($products as $product) {?>
                <tr class="gradeX">
                  <td><?=$product['id'] ?></td>
                  <td>
                      <?php $tyn=""; foreach($product['categories'] as $ty){
                           echo $tyn=$ty['cat_id'];echo ",";
                          }?>  </td>
                    <td><?php $tyn=""; foreach($product['categories'] as $ty){
                           echo $tyn=$ty['cat_name']; echo ",";
                          }?></td>
                  <td><?= $product->product_name ?></td>
                    <td><?= $product->product_code ?></td>
                    <td><?= $product->product_color ?></td>
                    <td><?= $product['price'] ?> </td>
                    <td> <?php $tyn=""; foreach($product['images'] as $ty){
                           $tyn=$ty['image'];
                          }?>
                    <img src="{{ asset('/images/backend_images/products/small/'.$tyn) }}" style="width:70px"></td>
                    <td class='center'><a href="#myModal{{ $product->id }}" data-toggle="modal"  class="btn btn-success btn-mini">View</a> <a href="{{ url('/admin/edit-product/'.$product->id) }}" class="btn btn-primary btn-mini">Edit</a> <a href="{{ url('/admin/add-attributes/'.$product->id) }}" class="btn btn-success btn-mini">Add</a> <a onclick="return confirm('Are you sure you want to delete this Product?');" href="{{ url('/admin/delete-product/'.$product->id) }}" class="btn btn-danger btn-mini">Delete</a></td>
                </tr>
                       
                            <div id="myModal{{ $product->id }}" class="modal hide">
                              <div class="modal-header">
                                  <button data-dismiss="modal" class="close" type="button">×</button>
                                  <h3>{{ $product->product_name }} Full Details</h3>
                              </div>
                              <div class="modal-body">
                                  <p>Product ID: {{ $product->id }}</p>
                                  <p>Category ID: <?php $tyn=""; foreach($product['categories'] as $ty){
                           echo $tyn=$ty['cat_id'];echo ",";
                          }?> </p>
                                  <p>Product Code: {{ $product->product_code }}</p>
                                  <p>Product Color: {{ $product->product_color }}</p>
                                  <p>Price: {{ $product->price }}</p>
                                  <p>Description: {{ $product->description }}</p>
                              </div>
                            </div>
                        
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection