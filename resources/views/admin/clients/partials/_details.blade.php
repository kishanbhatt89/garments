@extends('layouts.master')

@section('content')
        
    @include('admin.clients.partials._toolbar_details')
    
    <div class="post d-flex flex-column-fluid" id="kt_post">
        
        <div id="kt_content_container" class="container-xxl">
         
            <div class="card">
                                                
                <div class="card-body py-4">

                    <div class="table-responsive">
                        
                        <table class="table align-middle table-row-dashed gy-5" id="">
                            
                            <tbody class="fs-6 fw-bold text-gray-600">

                                <tr>
                                    <td>Name</td>
                                    <td>{{ $user->name ?? '' }}</td>                                    
                                </tr>
                                
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $user->email ?? '' }}</td>                                    
                                </tr>

                                <tr>
                                    <td>Active/Block</td>
                                    <td>
                                        @if ($user->is_active == 1)
                                            <span class="badge badge-light-success">Active</span>
                                        @else
                                            <span class="badge badge-light-danger">Block</span>
                                        @endif
                                    <td>                                    
                                </tr>

                                <tr>
                                    <td>State</td>
                                    <td>{{ $user->state->name ?? '' }}</td>                                    
                                </tr>

                                <tr>
                                    <td>City</td>
                                    <td>{{ $user->city->name ?? '' }}</td>                                    
                                </tr>

                                <tr>
                                    <td>Mobile</td>
                                    <td>{{ $user->clientDetails->mobile ?? '' }}</td>                                    
                                </tr>

                                <tr>
                                    <td>Address</td>
                                    <td>{{ $user->clientDetails->address ?? '' }}</td>                                    
                                </tr>

                                <tr>
                                    <td>Created At</td>
                                    <td>{{ $user->created_at->diffForHumans() ?? '' }}</td>                                    
                                </tr>

                                <tr>
                                    <td>Updated At</td>
                                    <td>{{ $user->updated_at->diffForHumans() ?? '' }}</td>                                    
                                </tr>

                                <tr>
                                    <td colspan="2" class="text-left">
                                        <a href="{{ route('admin.clients.index') }}" class="btn btn-primary">Back To Clients List</a>
                                    </td>                                    
                                </tr>

                            </tbody>
                            
                        </table>
                        
                    </div>

                </div>
                
            </div>
            
        </div>
        
    </div>    

@endsection

@section('custom-js')
    <script src="{{ asset('gapp') }}/js/custom/clients/client-dataTable.js"></script>
    <script src="{{ asset('gapp') }}/js/custom/clients/client-functions.js"></script>
    <script src="{{ asset('gapp') }}/js/custom/clients/client-utils.js"></script>
@endsection