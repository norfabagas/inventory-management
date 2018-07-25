<html>
  <tr style="background-color: #dfdfdf">
    <td>No</td>
    <td>Name</td>
    <td>Category</td>
    <td>Detail</td>
    <td>Quantity</td>
    <td>Person In Charge</td>
    <td>Create Date</td>
    <td>Update Date</td>
  </tr>

  @foreach($drops as $indexKey=>$a)
  <tr>
    <td>{{ $indexKey+1 }}</td>
    <td>{{ $a->stuff_name }}</td>
    <td>{{ $a->category }}</td>
    <td>{{ $a->detail }}</td>
    <td>{{ $a->quantity }}</td>
    <td>{{ $a->person }}</td>
    <td>{{ $a->created_at }}</td>
    <td>{{ $a->updated_at }}</td>
  </tr>
  @endforeach
</html>
