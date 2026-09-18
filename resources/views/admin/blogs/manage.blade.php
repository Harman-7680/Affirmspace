@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid" style="padding-left:300px; padding-right:20px;">

        <h3 class="my-1">Manage Blogs</h3>

        <div x-data="blogManager()">

            {{-- Add Blog --}}
            <div class="d-flex align-items-start gap-3 w-100">

                {{-- LEFT SIDE : 4 INPUTS --}}
                <div style="width:30%;">

                    {{-- Slug --}}
                    <div class="mb-2">
                        <input type="text" x-model="slug" placeholder="Slug" class="form-control" style="height:40px;">
                    </div>

                    {{-- Title --}}
                    <div class="mb-2">
                        <input type="text" x-model="short_description" placeholder="Title" class="form-control"
                            style="height:40px;">
                    </div>

                    {{-- Link --}}
                    <div class="mb-2">
                        <input type="text" x-model="link" placeholder="Link" class="form-control" style="height:40px;">
                    </div>

                    {{-- Browser / File Chosen --}}
                    <div class="mb-2">
                        <input type="file" @change="handleImage" class="form-control" style="height:40px;">
                    </div>

                    {{-- Category --}}
                    <div class="mb-0">
                        <select x-model="category" class="form-control" style="height:40px;">
                            <option value="">Select Category</option>
                            <option value="LGBTQ Basics">LGBTQ Basics</option>
                            <option value="Identity & Expression">Identity & Expression</option>
                            <option value="Mental Health & Support">Mental Health & Support</option>
                            <option value="Dating & Relationships">Dating & Relationships</option>
                            <option value="Safety & Coming Out">Safety & Coming Out</option>
                            <option value="Community & Culture">Community & Culture</option>
                            <option value="Legal Rights India">Legal Rights India</option>
                            <option value="Gender Affirming Care">Gender Affirming Care</option>
                        </select>
                    </div>

                </div>


                {{-- RIGHT SIDE : QUILL EDITOR --}}
                <div style="width:35%; margin-left:20px;">

                    {{-- Quill --}}
                    <div id="description-editor" style="height:240px; background:white;">
                    </div>

                </div>


                {{-- Spacer --}}
                <div style="width: 20px;"></div>


                {{-- ADD BUTTON --}}
                <div style="width:auto; ">
                    <button class="btn btn-primary px-4" @click="addBlog()" style="height:40px; min-width: 90px;">
                        Add
                    </button>
                </div>


                {{-- PAGINATION --}}
                <div class="my-2 d-flex align-items-center justify-content-end gap-2"
                    style="margin-left:auto; white-space:nowrap;">

                    <button class="pagination-btn pagination-btn-outline mx-1" :disabled="currentPage === 1"
                        @click="prevPage">
                        Prev
                    </button>

                    <span>
                        Page <strong x-text="currentPage"></strong>
                        of <strong x-text="totalPages"></strong>
                    </span>

                    <button class="pagination-btn pagination-btn-outline mx-1" :disabled="currentPage === totalPages"
                        @click="nextPage">
                        Next
                    </button>

                </div>

            </div>

            <template x-if="comments.length > 0">
                <div>
                    <h4>Pending Comments</h4>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover table-striped text-center mb-1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <template x-for="(comment, index) in comments" :key="comment.id">
                                    <tr>
                                        <td x-text="index+1"></td>
                                        <td x-text="comment.name"></td>
                                        <td x-text="comment.comment"></td>

                                        <td x-text="blogs.find(b => b.id === comment.parent_id)?.category"></td>
                                        <td x-text="blogs.find(b => b.id === comment.parent_id)?.short_description"></td>
                                        <td x-text="blogs.find(b => b.id === comment.parent_id)?.long_description"></td>

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
                </div>
            </template>

            {{-- Blog Table --}}

            <h4 class="mt-2">Uploaded Blogs</h4>

            <div class="mb-2 p-3 rounded shadow-sm border">

                <!-- CATEGORY HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0 text-primary fw-bold">
                        <span x-text="formatCategory(currentCategory)"></span>
                    </h5>
                    <span class="badge bg-dark" x-text="currentBlogs.length + ' Blogs'"></span>
                </div>

                <!-- BLOG CARDS (5 per row, image height increased to 110px) -->
                <div class="row">
                    <template x-for="blog in currentBlogs" :key="blog.id">
                        <div class="mb-0 px-2" style="flex: 0 0 20%; max-width: 20%;">

                            <div class="card h-100 shadow-sm border-0" style="border-radius:6px; overflow:hidden;">

                                <img :src="'/storage/' + blog.image" class="card-img-top"
                                    style="height:110px; object-fit:cover;">

                                <div class="card-body p-2">
                                    <h6 class="fw-bold text-dark text-truncate mb-1" style="font-size: 14px;"
                                        x-text="blog.short_description"></h6>

                                    <p class="text-muted mb-0"
                                        style="font-size: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
                                        x-text="stripHtml(blog.long_description)"></p>
                                </div>

                                <div class="card-footer bg-white d-flex justify-content-between p-1 border-top-0">
                                    <button class="btn btn-sm btn-warning px-2 py-0" style="font-size:10px; height:22px;"
                                        @click="openEdit(blog)">Edit</button>
                                    <button class="btn btn-sm btn-danger px-2 py-0" style="font-size:10px; height:22px;"
                                        @click="deleteBlog(blog.id)">Delete</button>
                                </div>

                            </div>

                        </div>
                    </template>
                </div>

            </div>

            <template x-if="showModal">

                <div
                    style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999;
        display:flex; align-items:center; justify-content:center;">

                    <div @click.stop
                        style="background:white; padding:20px; width:600px; max-width:95%;
            border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,0.2);">

                        <h4 class="mb-3">Edit Blog</h4>

                        {{-- Slug --}}
                        <input type="text" x-model="editBlog.slug" class="form-control mb-2" placeholder="Slug">

                        {{-- Title --}}
                        <input type="text" x-model="editBlog.short_description" class="form-control mb-2"
                            placeholder="Title">

                        {{-- Link --}}
                        <input type="text" x-model="editBlog.link" class="form-control mb-2" placeholder="Link">

                        {{-- Image --}}
                        <input type="file" @change="handleEditImage" class="form-control mb-2">

                        {{-- Description --}}
                        <label class="fw-bold mb-1">Description</label>

                        <div id="edit-description-editor" style="height:200px; background:white; margin-bottom:10px;">
                        </div>

                        {{-- Category --}}
                        <select x-model="editBlog.category" class="form-control mb-3">

                            <option value="LGBTQ Basics">LGBTQ Basics</option>
                            <option value="Identity & Expression">Identity & Expression</option>
                            <option value="Mental Health & Support">Mental Health & Support</option>
                            <option value="Dating & Relationships">Dating & Relationships</option>
                            <option value="Safety & Coming Out">Safety & Coming Out</option>
                            <option value="Community & Culture">Community & Culture</option>
                            <option value="Legal Rights India">Legal Rights India</option>
                            <option value="Gender Affirming Care">Gender Affirming Care</option>

                        </select>

                        <div class="text-end">

                            <button class="btn btn-secondary" @click="showModal = false">
                                Cancel
                            </button>

                            <button class="btn btn-primary" @click="updateBlog()">
                                Update
                            </button>

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
                long_description: '',
                image: null,
                showModal: false,
                editBlog: {},
                editImage: null,
                link: '',
                quill: null,
                editQuill: null,

                /* pagination */

                currentPage: 1,
                perPage: 10,

                init() {
                    this.initQuill();
                },

                initEditQuill() {

                    this.editQuill = new Quill('#edit-description-editor', {

                        theme: 'snow',

                        modules: {

                            toolbar: [
                                ['bold', 'italic', 'underline'],

                                [{
                                    'header': [1, 2, 3, false]
                                }],

                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],

                                ['link']
                            ]

                        }

                    });

                },

                stripHtml(html) {
                    const div = document.createElement('div');
                    div.innerHTML = html || '';

                    let text = div.textContent || div.innerText || '';

                    return text.length > 60 ?
                        text.substring(0, 60) + '...' :
                        text;
                },

                openEdit(blog) {
                    this.editBlog = {
                        ...blog
                    }

                    this.editImage = null;
                    this.showModal = true;

                    this.$nextTick(() => {

                        if (!this.editQuill) {
                            this.editQuill = new Quill('#edit-description-editor', {
                                theme: 'snow',
                                modules: {
                                    toolbar: [
                                        ['bold', 'italic', 'underline'],
                                        [{
                                            'header': [1, 2, 3, false]
                                        }],
                                        [{
                                            'list': 'ordered'
                                        }, {
                                            'list': 'bullet'
                                        }],
                                        ['link']
                                    ]
                                }
                            });
                        }

                        // Purani description Quill me load hogi
                        this.editQuill.root.innerHTML = blog.long_description || '';
                    });
                },

                handleEditImage(e) {
                    this.editImage = e.target.files[0]
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

                initQuill() {
                    this.quill = new Quill('#description-editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                [{
                                    'header': [1, 2, 3, false]
                                }],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['link']
                            ]
                        }
                    });
                },

                addBlog() {

                    let formData = new FormData()

                    formData.append('slug', this.slug)
                    formData.append('category', this.category)
                    formData.append('short_description', this.short_description)
                    formData.append('long_description', this.quill.root.innerHTML)
                    formData.append('image', this.image)
                    formData.append('link', this.link)

                    fetch("/manage/blog/store", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(async res => {

                            if (!res.ok) {
                                let errorData = await res.json()

                                if (errorData.errors) {
                                    let messages = Object.values(errorData.errors).flat().join('\n')
                                    alert(messages) // ALERT SHOW
                                }

                                throw new Error('Validation failed')
                            }

                            return res.json()
                        })
                        .then(data => {

                            if (data.success) {

                                this.blogs.unshift(data.blog)

                                this.slug = ''
                                this.category = ''
                                this.short_description = ''
                                this.long_description = ''
                                this.quill.root.innerHTML = ''
                                this.link = ''

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
                    formData.append(
                        'long_description',
                        this.editQuill.root.innerHTML
                    )
                    formData.append('link', this.editBlog.link)

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
                },
                get groupedBlogs() {
                    let grouped = {}

                    this.blogs.forEach(blog => {
                        if (!grouped[blog.category]) {
                            grouped[blog.category] = []
                        }
                        grouped[blog.category].push(blog)
                    })

                    return grouped
                },
                get currentCategory() {
                    return this.categories[this.currentPage - 1] || null
                },
                get categories() {
                    return Object.keys(this.groupedBlogs)
                },
                get currentBlogs() {
                    return this.groupedBlogs[this.currentCategory] || []
                },
                get totalPages() {
                    return this.categories.length || 1
                },
                formatCategory(category) {
                    return category
                        .replace(/-/g, ' ')
                        .toLowerCase()
                        .replace(/\b\w/g, char => char.toUpperCase())
                }

            }

        }
    </script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

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
