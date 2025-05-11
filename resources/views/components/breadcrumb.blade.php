<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            @foreach ($breadcrumb as $item)
                @if ($item['active'])
                    <li class="breadcrumb-item active">{{ $item['name'] }}</li>
                @else
                    <li class="breadcrumb-item "><a href="#">{{ $item['name'] }}</a></li>
                @endif
            @endforeach
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
