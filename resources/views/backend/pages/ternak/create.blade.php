@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important;
        }

        label {
            float: left;
            color: black;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
    </style>

    <div class="main-content-inner">
        <div class="row">
            @include('backend.layouts.partials.messages')
            <form action="{{ route('ternak.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">


                                <div class="row">
                                    <div class="mb-3 col-sm-6">
                                        <label for="name">Name<span class="font-danger">*</span></label>
                                        <input class="form-control" type="text" required="" id="name"
                                            name="name" value="">

                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="IdentificationNumber">Tag Number<span
                                                class="font-danger">*</span></label>
                                        <input class="form-control" type="text" required="" id="tag_number"
                                            name="tag_number" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-sm-6">
                                        <label for="Gender">Gender<span class="font-danger">*</span></label>
                                        <select class="form-select" required="" id="gender" name="gender">
                                            <option value="">Select...</option>
                                            <option value="None">None</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="date_birthday">Date of Birth<span class="font-danger">*</span></label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="date" autocomplete="off" required="" class="form-control"
                                                placeholder="dd-M-yyyy" data-date-format="dd-M-yyyy"
                                                data-date-container="#datepicker2" data-provide="datepicker"
                                                data-date-autoclose="true" id="date_birthday" name="date_birthday"
                                                value="">
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-xl-6 col-sm-12">
                                        <label for="is_full_breed">Is Full breed</label>
                                        <select class="form-select" required="" id="is_full_breed" name="is_full_breed">
                                            <option value="" selected="">Select...</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-xl-6 col-sm-12">
                                        <label for="pig_pen">PigPen</label>

                                        <div class="input-group">
                                            <select class="form-select " data-val="true"
                                                data-val-required="The PigPEN field is required." id="pig_pen"
                                                name="pig_pen" data-select2-id="pig_pen" tabindex="-1"
                                                aria-hidden="true">
                                                <option value="" data-select2-id="5">Select...</option>
                                                @foreach ($kandang as $item)
                                                    <option value="{{ $item->id }}">{{ $item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="mb-3 col-xl-6 col-sm-12">
                                        <label for="breed">Breed</label>
                                        <select class="form-control " data-placeholder="Select ..." id="breed"
                                            name="breed" data-select2-id="breed" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="">Unknown</option>
                                            <option value="Berkshire">Berkshire</option>
                                            <option value="Chester White">Chester White</option>
                                            <option value="Duroc">Duroc</option>
                                            <option value="Hampshire">Hampshire</option>
                                            <option value="Hereford">Hereford</option>
                                            <option value="Landrace">Landrace</option>
                                            <option value="Large Black">Large Black</option>
                                            <option value="Large White">Large White</option>
                                            <option value="Spotted">Spotted</option>
                                            <option value="Tamworth">Tamworth</option>
                                            <option value="Yorkshire">Yorkshire</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-xl-6 col-sm-12">
                                        <label for="is_breeding_stok">Is Breeding Stock<span
                                                class="font-danger">*</span></label>
                                        <select class="form-select" required="" id="is_breeding_stok"
                                            name="is_breeding_stok">
                                            <option value="" selected="">Select...</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="comment">Comment</label>
                                    <textarea class="form-control" id="comment" name="comment"></textarea>

                                </div>

                                <button class="btn btn-primary" type="submit">Submit</button>
                                <a class="btn btn-outline-primary" href="{{ route('ternak') }}">Cancel</a>


                            </div>
                        </div>


                    </div> <!-- end col -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-xl-6 col-sm-12">
                                        <label for="father_tag">Father Tag Number</label>
                                        <input class="form-control" type="text" id="father_tag"
                                            name="father_tag" value="">
                                    </div>
                                    <div class="col-xl-6 col-sm-12">
                                        <label for="mother_tag">Mother Tag Number</label>
                                        <input class="form-control" type="text" id="mother_tag"
                                            name="mother_tag" value="">
                                    </div>
                                </div>



                            </div>
                        </div>


                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <label for="Weight">Weight</label>
                                        <div class="input-group">
                                            <input class="form-control" type="number" step="any" data-val="true"
                                                data-val-number="The field Weight must be a number."
                                                data-val-required="The Weight field is required." id="Weight"
                                                name="weight" value="0">
                                            <span class="input-group-text" id="WeightMeasurementUnitName">Kg</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12">
                                        <label for="Height">Height</label>
                                        <div class="input-group">
                                            <input class="form-control" type="number" step="any" data-val="true"
                                                data-val-number="The field Height must be a number." id="Height"
                                                name="height" value="">
                                            <span class="input-group-text" id="HeightMeasurementUnitName">cm</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-xl-12 col-sm-12">
                                        <label for="Color">Color</label>
                                        <input class="form-control" type="text" id="Color" name="color"
                                            value="">
                                    </div>

                                </div>


                            </div>
                        </div>


                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <label for="purchase_date">Purchase Date</label>
                                        <div class="input-group" id="datepicker3">
                                            <input type="date" autocomplete="off" required="" class="form-control"
                                                placeholder="dd-M-yyyy" data-date-format="dd-M-yyyy"
                                                data-date-container="#datepicker3" data-provide="datepicker"
                                                data-date-autoclose="true" id="purchase_date" name="purchase_date"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <label for="purchased_from">Purchased From</label>
                                        <input class="form-control" type="text" id="purchased_from"
                                            name="purchased_from" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <label for="date_delivered_to_farm">Date Delivered to Farm<span
                                                class="font-danger">*</span></label>
                                        <div class="input-group" id="datepicker4">
                                            <input type="date" autocomplete="off" required="" class="form-control"
                                                placeholder="dd-M-yyyy" data-date-format="dd-M-yyyy"
                                                data-date-container="#datepicker4" data-provide="datepicker"
                                                data-date-autoclose="true" id="date_delivered_to_farm" name="date_delivered_to_farm"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <label for="purchase_price">Purchase Price</label>
                                        <div class="input-group">
                                            <div class="input-group-text">Rp</div>
                                            <input class="form-control" type="number" step="any"
                                                placeholder="Enter Cost" data-val="true"
                                                data-val-number="The field purchase_price must be a number."
                                                data-val-required="The purchase_price field is required."
                                                id="purchase_price" name="purchase_price" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="input-group-text">Photo</div>

                                <div class="row">
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <div class="d-flex py-3">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <input name="photo1" class="form-control"
                                                    formnovalidate="formnovalidate" accept=".png, .jpg, .jpeg, .gif"
                                                    type="file" id="Image1File" name="Image1File">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <div class="d-flex py-3">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <input name="photo2" class="form-control"
                                                    formnovalidate="formnovalidate" accept=".png, .jpg, .jpeg, .gif"
                                                    type="file" id="Image2File" name="Image2File">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <div class="d-flex py-3">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <input name="photo3" class="form-control"
                                                    formnovalidate="formnovalidate" accept=".png, .jpg, .jpeg, .gif"
                                                    type="file" id="Image3File" name="Image3File">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-sm-12 mb-3">
                                        <div class="d-flex py-3">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <input name="photo4" class="form-control"
                                                    formnovalidate="formnovalidate" accept=".png, .jpg, .jpeg, .gif"
                                                    type="file" id="Image4File" name="Image4File">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>




                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

    <script>
        // Initialize Dropify
        $('.dropify').dropify();
    </script>
@endsection
