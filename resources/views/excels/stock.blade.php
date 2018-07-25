<html>
  <tr style="background-color: #dfdfdf">
    <td>No</td>
    <td>Name</td>
    <td>Category</td>
    <td>Quantity</td>
    <td>Condition</td>
    <td>location</td>
    <td>Size</td>
    <td>Detail</td>
    <td>Create Date</td>
    <td>Update Date</td>
  </tr>

  @foreach($stocks as $indexKey=>$a)
  <tr>
    <td>{{ $indexKey+1 }}</td>
    <td>{{ $a->name }}</td>
    <td>{{ $a->category }}</td>
    <td>{{ $a->quantity }}</td>
    <td>{{ $a->condition }}</td>
    <td>{{ $a->location }}</td>
    <td>{{ $a->size }}</td>
    <td>{{ $a->detail }}</td>
    <td>{{ $a->created_at }}</td>
    <td>{{ $a->updated_at }}</td>
  </tr>
  @endforeach
</html>
