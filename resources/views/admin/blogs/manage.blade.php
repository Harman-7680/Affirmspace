@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid" style="padding-left:300px; padding-right:20px;">

        <h3 class="my-3">Manage Blogs</h3>

        <div x-data="blogManager()">

            {{-- Add Blog --}}

            <div class="mb-2 d-flex align-items-center gap-3 flex-nowrap w-100">

                <input type="text" x-model="slug" placeholder="Blog Title" class="form-control"
                    style="width:20%; height:40px; margin-right:10px;">

                <select x-model="category" class="form-control" style="width:20%; height:40px; margin-right:10px;">
                    <option value="">Select Category</option>
                    <option value="Health">Health</option>
                    <option value="Career">Career</option>
                    <option value="Relationship">Relationship</option>
                    <option value="Mental">Mental</option>
                    <option value="Education">Education</option>
                </select>

                <input type="text" x-model="short_description" placeholder="Short Description" class="form-control"
                    style="width:20%; height:40px; margin-right:10px;">

                <input type="file" @change="handleImage" class="form-control"
                    style="width:20%; height:40px; margin-right:10px;">

                <button class="btn btn-primary" @click="addBlog()" style="height:40px;">
                    Add
                </button>

                {{-- Pagination --}}
                <div class="my-2 flex items-center justify-end gap-2">
                    <button class="pagination-btn pagination-btn-outline mx-1" :disabled="currentPage === 1"
                        @click="prevPage">
                        Prev
                    </button>

                    <span>
                        Page <strong x-text="currentPage"></strong> of <strong x-text="totalPages"></strong>
                    </span>

                    <button class="pagination-btn pagination-btn-outline mx-1" :disabled="currentPage === totalPages"
                        @click="nextPage">
                        Next
                    </button>
                </div>

            </div>

            {{-- Blog Table --}}

            <div class="table-responsive">

                <table class="table table-sm table-bordered table-hover table-striped text-center mb-0">

                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Slug</th>
                            <th>Category</th>
                            <th>Short Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <template x-for="(blog,index) in paginatedBlogs()" :key="blog.id">

                            <tr>

                                <td x-text="(currentPage-1)*perPage + index + 1"></td>

                                <td x-text="blog.slug"></td>

                                <td x-text="blog.category"></td>

                                <td x-text="blog.short_description"></td>

                                <td>
                                    <img :src="'/storage/' + blog.image" width="60">
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-warning" @click="openEdit(blog)">Edit</button>

                                    <button class="btn btn-sm btn-danger" @click="deleteBlog(blog.id)">
                                        Delete
                                    </button>
                                </td>

                            </tr>

                        </template>

                    </tbody>

                </table>

            </div>

            <h4 class="mt-4">Pending Comments</h4>

            <div class="table-responsive">

                <table class="table table-sm table-bordered table-hover table-striped text-center mb-0">

                    <thead class="thead-dark">

                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <template x-for="(comment,index) in comments" :key="comment.id">

                            <tr>

                                <td x-text="index+1"></td>

                                <td x-text="comment.name"></td>

                                <td x-text="comment.comment"></td>

                                <td>

                                    <button class="btn btn-sm btn-success" @click="approve(comment.id)">
                                        Approve
                                    </button>

                                    <button class="btn btn-sm btn-danger" @click="reject(comment.id)">
                                        Reject
                                    </button>

                                </td>

                            </tr>

                        </template>

                    </tbody>

                </table>

            </div>

            <template x-if="showModal">
                <div
                    style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999;
        display:flex; align-items:center; justify-content:center;">

                    <div @click.stop
                        style="background:white; padding:20px; width:400px; border-radius:10px; 
            box-shadow:0 10px 30px rgba(0,0,0,0.2);">

                        <h4>Edit Blog</h4>

                        <input type="text" x-model="editBlog.slug" class="form-control mb-2">

                        <select x-model="editBlog.category" class="form-control mb-2">
                            <option value="Health">Health</option>
                            <option value="Career">Career</option>
                            <option value="Relationship">Relationship</option>
                            <option value="Mental">Mental</option>
                            <option value="Education">Education</option>
                        </select>

                        <input type="text" x-model="editBlog.short_description" class="form-control mb-2">

                        <input type="file" @change="handleEditImage" class="form-control mb-2">

                        <div class="text-end">
                            <button class="btn btn-secondary" @click="showModal = false">Cancel</button>
                            <button class="btn btn-primary" @click="updateBlog()">Update</button>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function blogManager() {

            return {

                blogs: @json($blogs),

                comments: @json($comments),

                slug: '',
                category: '',
                short_description: '',
                image: null,
                showModal: false,
                editBlog: {},
                editImage: null,

                /* pagination */

                currentPage: 1,
                perPage: 10,

                openEdit(blog) {
                    this.editBlog = {
                        ...blog
                    }
                    this.showModal = true
                },

                handleEditImage(e) {
                    this.editImage = e.target.files[0]
                },

                get totalPages() {
                    return Math.ceil(this.blogs.length / this.perPage) || 1
                },

                paginatedBlogs() {

                    const start = (this.currentPage - 1) * this.perPage

                    return this.blogs.slice(start, start + this.perPage)

                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--
                    }
                },


                /* image */

                handleImage(e) {

                    this.image = e.target.files[0]

                },


                /* add blog */

                addBlog() {

                    let formData = new FormData()

                    formData.append('slug', this.slug)
                    formData.append('category', this.category)
                    formData.append('short_description', this.short_description)
                    formData.append('image', this.image)

                    fetch("/manage/blog/store", {

                            method: 'POST',

                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            body: formData

                        })

                        .then(res => res.json())

                        .then(data => {

                            if (data.success) {

                                this.blogs.unshift(data.blog)

                                this.slug = ''
                                this.category = ''
                                this.short_description = ''

                                this.currentPage = 1

                            }

                        })

                },


                /* approve comment */

                approve(id) {

                    fetch("/manage/comment/approve/" + id, {

                            method: 'POST',

                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }

                        })

                        .then(res => res.json())

                        .then(data => {

                            if (data.success) {

                                this.comments = this.comments.filter(c => c.id !== id)

                            }

                        })

                },


                /* reject comment */

                reject(id) {

                    fetch("/manage/comment/reject/" + id, {

                            method: 'POST',

                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }

                        })

                        .then(res => res.json())

                        .then(data => {

                            if (data.success) {

                                this.comments = this.comments.filter(c => c.id !== id)

                            }

                        })

                },

                updateBlog() {

                    let formData = new FormData()

                    formData.append('slug', this.editBlog.slug)
                    formData.append('category', this.editBlog.category)
                    formData.append('short_description', this.editBlog.short_description)

                    if (this.editImage) {
                        formData.append('image', this.editImage)
                    }

                    fetch("/manage/blog/update/" + this.editBlog.id, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {

                                let index = this.blogs.findIndex(b => b.id === this.editBlog.id)

                                this.blogs[index] = data.blog

                                this.showModal = false
                            }
                        })
                },

                deleteBlog(id) {

                    if (!confirm('Delete this blog?')) return

                    fetch("/manage/blog/delete/" + id, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.blogs = this.blogs.filter(b => b.id !== id)
                            }
                        })
                }

            }

        }
    </script>
@endsection

@section('css')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .modal-overlay {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
