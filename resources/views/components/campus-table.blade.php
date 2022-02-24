<table class="min-w-full leading-normal campus-table">
    <thead>
        <tr>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Campus Name
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Address
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Status
            </th>
            <th scope="col"
                class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                Created At
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<script type="text/javascript">
  $(function () {
    
    var table = $('.campus-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('campus.index') }}",
        columns: [
            {data: 'campus_name', name: 'campus_name'},
            {data: 'address', name: 'address'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>
