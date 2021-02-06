<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <div class="col">
            <button class="tdd active">
              <a href="show">Entry</a>
            </button>
            <!-- <button class="tdd">
              <a href="eviction">Eviction</a>
            </button> -->
          </div>
          <hr class="new4">

          <div class="col">
         @if($cat=\App\Contestant::get('categories')->unique('categories'))
         @foreach($cat as $group)
         <button class="tdd" >
         @if($contestants[0]->categories==$group->categories)
         <a href="{{route('admin.show',$group->categories)}}" style= "color:red">{{$group->categories}}    </a>
         @else
         <a href="{{route('admin.show',$group->categories)}}" >{{$group->categories}}    </a>
         @endif
            </button >
            @endforeach
         @endif
       
            
          </div>
        </div>
        <div class="col-lg-6 col-5 text-right">
          
          <div class="col account">
            <div class="class-box" style="width:100px; height: 150px";>
             <div class="dropdown">
                <button class="dropbtn">class 1</button>
               <span class="con">{{ \App\Contestant::where(['status' => 'Contestant'])->where(['class' => 'Class1'])->count() }}</span>
               <div class="dropdown-content" style= "min-width:100px; font-size: 10px";>
                <!-- <a href="#">Contestants 1</a>
                <a href="#">Contestants 2</a>
                <a href="#">Contestants 3</a> -->
                </div>
               </div>
               <div class="dropdown">
                <button class="dropbtn">class 2</button>
               <span class="con">{{ \App\Contestant::where(['status' => 'Contestant'])->where(['class' => 'Class2'])->count() }}</span>
               <div class="dropdown-content" style= "min-width:100px; font-size: 10px";>
                <!-- <a href="#">Contestants 1</a>
                <a href="#">Contestants 2</a>
                <a href="#">Contestants 3</a> -->
                </div>
               </div>
               <div class="dropdown">
                <button class="dropbtn">class 3</button>
               <span class="con">{{ \App\Contestant::where(['status' => 'Contestant'])->where(['class' => 'Class3'])->count() }}</span>
               <div class="dropdown-content" style= "min-width:100px; font-size: 10px";>
                <!-- <a href="#">Contestants 1</a>
                <a href="#">Contestants 2</a>
                <a href="#">Contestants 3</a> -->
                </div>
               </div>
              <div class="dropdown">
              <button class="dropbtn">class 4</button>
              <span class="con">{{ \App\Contestant::where(['status' => 'Contestant'])->where(['class' => 'Class4'])->count() }}</span>
              <div class="dropdown-content" style= "min-width:100px; font-size: 10px";>
                <!-- <a href="#">Contestants 4</a>
                <a href="#">Contestants 5</a>
                <a href="#">Contestants 6</a> -->
              </div>
            </div>


           
            
          </div>

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
          <h3 class="mb-0">Entry</h3>
        </div>

        <div class="row">
        <div class="dropdown">
          <button class="dropbtn">Cancel</button>
          <span class="con">{{ \App\Contestant::where(['status' => 'Contestant'])->where(['class' => 'Cancel'])->count() }}</span>
          <div class="dropdown-content" style= "min-width:100px; font-size: 10px";>
            <!-- <a href="#">Contestants 4</a>
            <a href="#">Contestants 5</a>
            <a href="#">Contestants 6</a> -->
          </div>
        </div>

        <div class="dropdown">
          <button class="dropbtn">Remain</button>
          <span class="con">{{ \App\Contestant::where(['status' => 'Contestant'])->where(['class' => 'None'])->count() }}</span>
          <div class="dropdown-content" style= "min-width:100px; font-size: 10px";>
            <!-- <a href="#">Contestants 4</a>
            <a href="#">Contestants 5</a>
            <a href="#">Contestants 6</a> -->
          </div>
        </div>

        <div class="dropdown">
          <button class="dropbtn">Total</button>
          <span class="con">{{ \App\Contestant::where(['status' => 'Contestant'])->where(['class' => ['Class1','Class2','Class3','Class4']])->count() }}</span>
          <div class="dropdown-content" style= "min-width:100px; font-size: 10px";>
            <!-- <a href="#">Contestants 4</a>
            <a href="#">Contestants 5</a>
            <a href="#">Contestants 6</a> -->
          </div>
        </div>
        </div>



        <!-- Light table -->
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
              <th scope="col">{{ __('ID') }}</th>
              <th scope="col">{{ __('Name') }}</th>
                <th scope="col">{{ __('Gender') }}</th>
                <th scope="col">{{ __('Category') }}</th>
                <th scope="col" class="sort" data-sort="completion">{{ __('Country') }}</th>
                
                <th scope="col" class="sort" data-sort="completion">{{ __('Action') }}</th>
                <th scope="col" class="sort" data-sort="completion">{{ __(' Video') }} </th>
              </tr>
            </thead>
            <tbody>@foreach ($contestants as $contestant)
              <tr>
              <td>{{ $loop->iteration + ((app('request')->has('page') ? (app('request')->input('page') - 1) : 0) * 8) }}</td>
              <td style='font-size:10px'>{{ $contestant->user->firstname != '' ? $contestant->user->firstname:'Nil' }} {{ $contestant->user->lastname!=''?$contestant->user->lastname:'Nil' }}</td>
           
              <td  style='font-size:10px'>{{ $contestant->user->gender }}</td>
              <td  style='font-size:10px'>{{ $contestant->categories }}</td>
              <td  style='font-size:10px'>{{  $contestant->user->country }}</td>
                <td>
                              <div class="dropdown">
                                @if($contestant->class!='None'  &&  $contestant->class!='Cancel')
                                  <a class="btn btn-sm" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style= "color:green">
                                      {{ __('Action') }} </i>
                                  </a>
                                  @elseif($contestant->class=='Cancel') 
                                  <a class="btn btn-sm" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style= "color:red">
                                    {{ __('Action') }} </i>
                                </a>
                                @else
                                <a class="btn btn-sm" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  {{ __('Action') }} </i>
                              </a>
                              @endif

                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                  
                                  @if ($contestant->class=='Class1')
                                          <a class="dropdown-item" href="{{route('admin.setClass',['Class1',$contestant->id])}}" style= "color:red">{{ __('Class-1') }}</a>
                                          @else<a class="dropdown-item" href="{{route('admin.setClass',['Class1',$contestant->id])}}"
                                          >{{ __('Class-1') }}</a>
                                          @endif

                                          @if ($contestant->class=='Class2')
                                          <a class="dropdown-item" href="{{route('admin.setClass',['Class2',$contestant->id])}}"style= "color:red">{{ __('Class-2') }}</a>
                                          @else<a class="dropdown-item" href="{{route('admin.setClass',['Class2',$contestant->id])}}">{{ __('Class-2') }}</a>
                                          @endif

                                          @if ($contestant->class=='Class3')
                                           <a class="dropdown-item" href="{{route('admin.setClass',['Class3',$contestant->id])}}"style= "color:red">{{ __('Class-3') }}</a>
                                          @else <a class="dropdown-item" href="{{route('admin.setClass',['Class3',$contestant->id])}}">{{ __('Class-3') }}</a>
                                          @endif

                                          @if ($contestant->class=='Class4')
                                        <a class="dropdown-item" href="{{route('admin.setClass',['Class4',$contestant->id])}}"style= "color:red">{{ __('Class-4') }}</a>
                                          @else <a class="dropdown-item" href="{{route('admin.setClass',['Class4',$contestant->id])}}">{{ __('Class-4') }}</a>
                                          @endif

                                          
                                          <a class="dropdown-item" href="{{route('admin.setClass',['Cancel',$contestant->id])}}">{{ __('Cancel') }}</a>
                                          
                                          
                                          @if ($contestant->class!='None')
                                          <a class="dropdown-item" href="{{route('admin.deselectClass',[$contestant->id])}}"style= "color:red">{{ __('Unselect') }}</a>
                                          @endif

                                          
                                       
                                         
                                          
                                  </div>
                              </div>
                          </td>
                <td>
  <div>
    @if ($contestant->class=='Cancel')
      <a href=
    "http://192.241.153.127/video/{{$contestant->videoUrl}}"   style= "color:red">video</a>  
  @else
  <a href=
  "http://192.241.153.127/video/{{$contestant->videoUrl}}">video</a>

  @endif

</div>  


                </td>
              </tr>
            </tbody>
            @endforeach
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

