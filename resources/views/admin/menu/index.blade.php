@extends('layouts.admin')

@section('content')
   <section>
      @if(session('success'))
         <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&#10006;</button>
               <h4><i class="icon fa fa-check"></i>{{session('success')}}</h4>
         </div>
      @endif
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">Menu Options</h3>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
               </button>
               <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
               </button>
            </div>
         </div>
         <div class="card-body p-0">
            <table class="table table-striped projects">
               <thead>
                  <tr>
                     <th style="width: 1%">
                        ID
                     </th>
                     <th style="width: 20%">
                        Dish Title
                     </th>
                     <th style="width: 8%" class="text-center">
                        Dish Description
                     </th>
                     <th style="width: 10%">
                        Dish Category
                     </th>
                     <th style="width: 20%">
                        Action Button
                     </th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($options as $option)
                     <tr>
                        <td>
                           {{ $option['id'] }}
                        </td>
                        <td>
                           {{ $option['name'] }}
                        </td>
                        <td class="project-state" style="width: 60%;">
                           {{ $option['description'] }}
                        </td>
                        <td class="project-state" style="width: 50%; text-align: left;">
                           {{ $option->category->name }}
                        </td>
                        <td class="project-actions text-right" style="display: inline-flex;">
                           <a class="btn btn-info btn-sm mr-2" href="{{ route('menu.edit',$option['id']) }}">
                              <i class="fas fa-pencil-alt"></i>
                              Edit 
                           </a>
                           <form action="{{ route('menu.destroy',$option['id']) }}" method="post">
                              @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                    <i class="fas fa-trash"></i>
                                    Remove
                                 </button>
                           </form>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
          <div style="margin-top: 5px; margin-left: 5px;">
            {{ $options->links('pagination::bootstrap-4') }}
         </div>
      </div>
   </section>
@endsection