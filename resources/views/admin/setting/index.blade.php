@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h3 class="page-title">Company Settings</h3>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="company_name" value="{{ old('company_name', $settings['company_name'] ?? '') }}" required>
                                @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input class="form-control" type="text" name="contact_person" value="{{ old('contact_person', $settings['contact_person'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" name="address" value="{{ old('address', $settings['address'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Country</label>
                                <input class="form-control" type="text" name="country" value="{{ old('country', $settings['country'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" value="{{ old('city', $settings['city'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>State/Province</label>
                                <input class="form-control" type="text" name="state" value="{{ old('state', $settings['state'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input class="form-control" type="text" name="postal_code" value="{{ old('postal_code', $settings['postal_code'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input class="form-control" type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input class="form-control" type="text" name="mobile" value="{{ old('mobile', $settings['mobile'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fax</label>
                                <input class="form-control" type="text" name="fax" value="{{ old('fax', $settings['fax'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Website Url</label>
                                <input class="form-control" type="url" name="website" value="{{ old('website', $settings['website'] ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h4>Social Links</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Facebook</label>
                                <input class="form-control" type="url" name="facebook" value="{{ old('facebook', $settings['facebook'] ?? '') }}" placeholder="https://facebook.com/yourpage">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Twitter</label>
                                <input class="form-control" type="url" name="twitter" value="{{ old('twitter', $settings['twitter'] ?? '') }}" placeholder="https://twitter.com/yourpage">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Instagram</label>
                                <input class="form-control" type="url" name="instagram" value="{{ old('instagram', $settings['instagram'] ?? '') }}" placeholder="https://instagram.com/yourpage">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>LinkedIn</label>
                                <input class="form-control" type="url" name="linkedin" value="{{ old('linkedin', $settings['linkedin'] ?? '') }}" placeholder="https://linkedin.com/company/yourpage">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h4>Logos</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Header Logo</label>
                                <input type="file" name="logo_header" class="form-control-file">
                                @if(!empty($settings['logo_header']))
                                    <img src="{{ asset('storage/' . $settings['logo_header']) }}" alt="Header Logo" style="max-height: 50px; margin-top: 10px;">
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Footer Logo</label>
                                <input type="file" name="logo_footer" class="form-control-file">
                                @if(!empty($settings['logo_footer']))
                                    <img src="{{ asset('storage/' . $settings['logo_footer']) }}" alt="Footer Logo" style="max-height: 50px; margin-top: 10px;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn">Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection