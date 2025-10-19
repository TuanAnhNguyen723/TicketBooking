@extends('admin.layout')

@section('title', 'Tạo sự kiện')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-plus-circle text-primary-600"></i>
                Tạo sự kiện
            </h2>
            <p class="text-gray-600 mt-1">Thêm sự kiện mới vào hệ thống</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
            
            <!-- Thông tin cơ bản -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-600"></i>
                    Thông tin cơ bản
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="form-label">Tên sự kiện <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                               class="form-input @error('name') border-red-500 @enderror"
                               placeholder="Nhập tên sự kiện">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="category" class="form-label">Loại <span class="text-red-500">*</span></label>
                        <select name="category" id="category" required 
                                class="form-input @error('category') border-red-500 @enderror">
                            <option value="">Chọn loại</option>
                            <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Sự kiện & Lễ hội</option>
                            <option value="attraction" {{ old('category') == 'attraction' ? 'selected' : '' }}>Địa điểm du lịch</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="location" class="form-label">Địa điểm <span class="text-red-500">*</span></label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" required 
                               class="form-input @error('location') border-red-500 @enderror"
                               placeholder="Nhập địa điểm tổ chức">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="short_description" class="form-label">Mô tả ngắn</label>
                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}" 
                           class="form-input @error('short_description') border-red-500 @enderror"
                           placeholder="Mô tả ngắn gọn về sự kiện">
                    @error('short_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="form-label">Mô tả chi tiết</label>
                    <textarea name="description" id="description" rows="4" 
                              class="form-textarea @error('description') border-red-500 @enderror"
                              placeholder="Mô tả chi tiết về sự kiện">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Giá vé -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-ticket-alt text-green-600"></i>
                    Giá vé
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="adult_price" class="form-label">Giá vé người lớn <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.01" name="adult_price" id="adult_price" value="{{ old('adult_price') }}" required 
                                   class="form-input pr-8 @error('adult_price') border-red-500 @enderror"
                                   placeholder="0.00">
                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">₫</span>
                        </div>
                        @error('adult_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="child_price" class="form-label">Giá vé trẻ em <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.01" name="child_price" id="child_price" value="{{ old('child_price') }}" required 
                                   class="form-input pr-8 @error('child_price') border-red-500 @enderror"
                                   placeholder="0.00">
                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">₫</span>
                        </div>
                        @error('child_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Thời gian -->
            <div class="space-y-4" id="time-section">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-purple-600"></i>
                    Thời gian
                </h3>
                
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="date-fields">
                    <div>
                        <label for="start_date" class="form-label">Ngày bắt đầu <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required 
                               class="form-input @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="end_date" class="form-label mt-4">Ngày kết thúc <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required 
                               class="form-input @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="opening_time" class="form-label">Giờ mở cửa</label>
                        <input type="time" name="opening_time" id="opening_time" value="{{ old('opening_time') }}" 
                               class="form-input @error('opening_time') border-red-500 @enderror">
                        @error('opening_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="closing_time" class="form-label">Giờ đóng cửa</label>
                        <input type="time" name="closing_time" id="closing_time" value="{{ old('closing_time') }}" 
                               class="form-input @error('closing_time') border-red-500 @enderror">
                        @error('closing_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Hình ảnh -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-images text-orange-600"></i>
                    Hình ảnh
                </h3>
                
                <!-- Ảnh đại diện -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-blue-600"></i>
                        Ảnh đại diện
                    </h4>
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <!-- Preview area -->
                        <div class="w-full md:w-48 flex-shrink-0">
                            <div class="preview-container aspect-square">
                                <!-- Placeholder -->
                                <div id="preview-image" class="preview-placeholder">
                                    <div class="text-center text-gray-400">
                                        <i class="fas fa-image text-4xl mb-2"></i>
                                        <p class="text-sm">Chưa có ảnh</p>
                                    </div>
                                </div>
                                <!-- Preview Image -->
                                <img id="preview-image-src" src="" alt="Preview" class="preview-image" style="display: none;">
                            </div>
                            <p class="text-xs text-gray-500 mt-2 text-center">Preview</p>
                        </div>
                        
                        <!-- Upload area -->
                        <div class="flex-1">
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 hover:border-primary-400 hover:bg-primary-50 transition-all duration-200">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-5xl mb-4"></i>
                                    <div class="space-y-2">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-lg font-medium text-primary-600 hover:text-primary-500 px-4 py-2 border border-primary-300 hover:border-primary-400 transition">
                                            <span>Chọn ảnh đại diện</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this, 'preview-image')">
        </label>
                                        <p class="text-sm text-gray-600">hoặc kéo thả ảnh vào đây</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF • Tối đa 2MB</p>
                                    </div>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Thư viện ảnh -->
                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-images text-green-600"></i>
                        Thư viện ảnh
                    </h4>
                    
                    <!-- Preview gallery -->
                    <div id="preview-gallery" class="mb-4 hidden">
                        <p class="text-sm text-gray-600 mb-3">Ảnh đã chọn:</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="gallery-preview-grid">
                        </div>
                    </div>
                    
                    <!-- Upload area -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 hover:border-primary-400 hover:bg-primary-50 transition-all duration-200">
                        <div class="text-center">
                            <i class="fas fa-images text-gray-400 text-5xl mb-4"></i>
                            <div class="space-y-2">
                                <label for="gallery_images" class="relative cursor-pointer bg-white rounded-lg font-medium text-primary-600 hover:text-primary-500 px-4 py-2 border border-primary-300 hover:border-primary-400 transition">
                                    <span>Chọn nhiều ảnh</span>
                                    <input id="gallery_images" name="gallery_images[]" type="file" class="sr-only" accept="image/*" multiple onchange="previewGalleryImages(this)">
        </label>
                                <p class="text-sm text-gray-600">hoặc kéo thả nhiều ảnh vào đây</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF • Tối đa 2MB mỗi ảnh</p>
                            </div>
                        </div>
                    </div>
                    @error('gallery_images')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cài đặt khác -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-cog text-gray-600"></i>
                    Cài đặt khác
                </h3>
                
                <div>
                    <label for="total_capacity" class="form-label">Tổng số vé (để trống nếu không giới hạn)</label>
                    <input type="number" min="0" name="total_capacity" id="total_capacity" value="{{ old('total_capacity') }}" 
                           class="form-input @error('total_capacity') border-red-500 @enderror"
                           placeholder="Số lượng vé tối đa">
                    @error('total_capacity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} 
                           class="form-checkbox h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Kích hoạt sự kiện ngay sau khi tạo
        </label>
                </div>
    </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.events.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    Hủy
                </a>
                <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Lưu sự kiện
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.preview-container {
    position: relative;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

.preview-placeholder {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9fafb;
    z-index: 1;
}

.preview-image {
    position: absolute;
    inset: 0;
    z-index: 10;
    object-fit: cover;
}
</style>

<script>
function previewImage(input, previewId) {
    const file = input.files[0];
    if (file) {
        console.log('File selected:', file.name, 'Size:', file.size);
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('File loaded successfully');
            const img = document.getElementById(previewId + '-src');
            const placeholder = document.getElementById(previewId);
            
            console.log('Elements found:', {
                img: !!img,
                placeholder: !!placeholder
            });
            
            if (img && placeholder) {
                img.src = e.target.result;
                img.style.display = 'block';
                img.style.zIndex = '10';
                placeholder.style.display = 'none';
                console.log('Preview updated successfully');
            } else {
                console.error('Missing elements for preview');
            }
        };
        reader.readAsDataURL(file);
    }
}

function previewGalleryImages(input) {
    const files = input.files;
    const preview = document.getElementById('preview-gallery');
    const grid = document.getElementById('gallery-preview-grid');
    grid.innerHTML = '';
    
    if (files.length > 0) {
        preview.classList.remove('hidden');
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-gray-200">
                        <img src="${e.target.result}" alt="Preview ${i + 1}" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute top-2 right-2 bg-primary-600 text-white text-xs px-2 py-1 rounded-full font-medium">
                        ${i + 1}
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                    </div>
                `;
                grid.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        }
    } else {
        preview.classList.add('hidden');
    }
}
</script>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const dateFields = document.getElementById('date-fields');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    function toggleFields() {
        if (categorySelect.value === 'event') {
            // Hiển thị date fields cho sự kiện
            dateFields.style.display = 'block';
            startDateInput.required = true;
            endDateInput.required = true;
            startDateInput.disabled = false;
            endDateInput.disabled = false;
        } else {
            // Ẩn date fields cho địa điểm du lịch
            dateFields.style.display = 'none';
            startDateInput.required = false;
            endDateInput.required = false;
            startDateInput.disabled = true;
            endDateInput.disabled = true;
            startDateInput.value = '';
            endDateInput.value = '';
        }
    }
    
    // Toggle on page load if there's an old value
    toggleFields();
    
    // Toggle when category changes
    categorySelect.addEventListener('change', toggleFields);
});
</script>
@endsection