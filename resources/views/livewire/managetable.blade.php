<div class="card-body">
    <div class="table-responsive">
      <table class="table mb-0"  id="myTable">
<thead class="thead-light ">
<tr>
<th>#</th>
<th>Name</th>
<th>Email Id</th>

<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody class="">
    @foreach ($table as $item)
    <tr>
        <th scope="row">{{$item->id}}</th>
        <td><img src="{{ asset('images/'.$item->image) }}" style="width:50px; height:50px;"/></td>
        <td>{{$item->value}}</td>
        <td>
            <label class="switch" id="status{{ $item->id }}">
                <input type="checkbox" onchange="updateStatus({{ $item->id }})" {{ $item->	active ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>
        </td>
       <td>
        <button class="btn btn-outline-success">Edit</button>&nbsp;&nbsp;&nbsp;
        <button class="btn btn-outline-danger">Delete</button>
       </td>
        </tr>
    @endforeach
</tbody>
</table>
</div>
<div class="pagination-container mt-3">
    <button onclick="prevPage()" id="btn_prev"  class="btn btn-outline-success">Prev</button>
    &nbsp;&nbsp;&nbsp;<span id="page-info"></span>&nbsp;&nbsp;&nbsp;
    <button onclick="nextPage()" id="btn_next"  class="btn btn-outline-success">Next</button>
</div>
</div>