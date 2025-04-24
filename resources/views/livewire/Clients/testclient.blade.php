<div>
    <h1>Products</h1>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create
              </button>
        </div>
        <div class="col">
            <livewire:create-edit-client />
        </div>
    </div>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($clients as $client)
          <tr>
            <th scope="row">{{$loop->index+1}}</th>
            <td>{{ $client->name }}</td>
            <td>
              <button @click="$dispatch('edit-mode',{id:{{$client->id}}})" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <livewire:create-edit-client >
</div>

{{-- <script>
  document.addEventListener('livewire:initialized',()=>{
    @this.on('refresh-products',(event)=>{
      //alert('product created/updated')
      var myModalEl=document.querySelector('#exampleModal')
      var modal=bootstrap.Modal.getOrCreateInstance(myModalEl)

      setTimeout(() => {
        modal.hide();
        @this.dispatch('reset-modal');
      }, 5000);
    })

    var mymodal=document.getElementById('exampleModal')
    mymodal.addEventListener('hidden.bs.modal',(event)=>{
        @this.dispatch('reset-modal');
    })
  })
</script> --}}
