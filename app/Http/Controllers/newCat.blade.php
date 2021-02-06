
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <div class="col">
           
          </div>
          <hr class="new4">

          <div class="col">
         @if($cat=\App\Contestant::get('categories')->unique('categories'))
         @foreach($cat as $group)
         <button class="tdd" >
         @if($contestants[0]->categories==$group->categories)
         <a href="{{route('admin.newCat',$group->categories)}}" style= "color:red">{{$group->categories}}    </a>
         @else
         <a href="{{route('admin.newCat',$group->categories)}}" >{{$group->categories}}    </a>
         @endif
            </button >
            @endforeach
         @endif
       
            
          </div>
        </div>
      
      </div>

      
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
     <div class="col">
      <div class="card">
        <!-- Card header -->
        <div class="card-header border-0">
          <h3 class="mb-0">Set Categories</h3>
        </div>

        <!-- Light table -->
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
              <th scope="col">{{ __('ID') }}</th>
              <th scope="col">{{ __('Username') }}</th>
              <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('Gender') }}</th>
                <th scope="col">{{ __('Category') }}</th>
                <th scope="col" class="sort" data-sort="completion">{{ __('Sub Category') }}</th>
                
                <th scope="col" class="sort" data-sort="completion">{{ __('New Category') }}</th>
                <th scope="col" class="sort" data-sort="completion">{{ __(' action') }} </th>
              </tr>
            </thead>
            <tbody>

            
            @foreach ($contestants as $contestant)
              <tr>
              <td>{{ $loop->iteration + ((app('request')->has('page') ? (app('request')->input('page') - 1) : 0) * 8) }}</td>
              <td style='font-size:10px'>{{ $contestant->user->username != '' ? $contestant->user->username:'Nil' }} </td>
           
              <td style='font-size:10px'>{{ $contestant->user->firstname != '' ? $contestant->user->firstname:'Nil' }} {{ $contestant->user->lastname!=''?$contestant->user->lastname:'Nil' }}</td>
           
              <td  style='font-size:10px'>{{ $contestant->user->gender }}</td>
              <td  style='font-size:10px'>{{ $contestant->categories }}</td>
              <td  style='font-size:10px'>{{  $contestant->subCategory }}</td>
              <td style='font-size:10px'>{{ $contestant->newCategory != '' ? $contestant->newCategory:''None' }} </td>
                <td>
                              <div class="dropdown">
                                
                                  <a class="btn btn-sm" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style= "color:green">
                                      {{ __('Action') }} </i>
                                  </a>
                                  

                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                  
                                  
                                          <a class="dropdown-item" href="{{route('admin.setCat',[$contestant->id,'Jupiter'])}}" style= "color:red">{{ __('Jupiter') }}</a>
                                         
                                          

                                          
                                          <a class="dropdown-item" href="{{route('admin.setCat',[$contestant->id,'Mars'])}}"style= "color:red">{{ __('Mars') }}</a>
                                         

                                          
                                           <a class="dropdown-item" href="{{route('admin.setCat',[$contestant->id,'Neptune'])}}"style= "color:red">{{ __('Neptune') }}</a>
                                         

                                          
                                        <a class="dropdown-item" href="{{route('admin.setCat',[$contestant->id,'Saturn'])}}"style= "color:red">{{ __('Saturn') }}</a>
                                         
                                          
                                          <a class="dropdown-item" href="{{route('admin.setCat',[$contestant->id,'Uranus'])}}">{{ __('Uranus') }}</a>
                                          
                                          
                                        
                                          <a class="dropdown-item" href="{{route('admin.setCat',[$contestant->id,'Venus'])}}"style= "color:red">{{ __('Venus') }}</a>
                                         
                                          
                                  </div>
                              </div>
                          </td>
           
              </tr>


              @endforeach
         

            </tbody>
        
          </table>
        </div>
        <!-- Card footer -->
        <div class="card-footer py-4">
        <nav class="d-flex justify-content-end" aria-label="...">
                       {{ $contestants->links('vendor.pagination.bootstrap-4') }}
                  </nav>
        </div>
      
      </div>
    </div>
  </div>

</div>

<script>

// $("#modal-default").on('hidden.bs.modal', function (e) {
// $("#modal-default source").attr("src", $("#modal-default source").attr("src"));
// });


$('#videoplayer').click(function(e) {
    e.preventDefault();
    $('#videoplayer1').children('iframe').attr('src', '');
  });

</script>


