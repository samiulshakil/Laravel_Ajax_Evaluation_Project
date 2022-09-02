                <div class="table-responsive">
                    <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="text-center">{{ $product->name }}</td>
                                    <td class="text-center">{{ $product->title }}</td>
                                    <td class="text-center">{{ $product->description }}</td>
                                    <td class="text-center">
                                        <img width="40" height="50" src="{{ asset($product->image) }}"
                                            alt="Avatar">
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="edit_data btn btn-primary btn-sm" type="button"
                                            data-id="{{ $product->id }}">
                                            Edit</a>
                                        <a class="btn btn-danger btn-sm delete_data" type="button"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                            Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
