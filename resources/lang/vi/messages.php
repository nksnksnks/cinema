<?php

return [
    'success' => [
        'success' => 'Thành công.',
        'category' => [
            'create' => 'Tạo danh mục thành công!',
            'edit' => 'Sửa danh mục thành công!',
            'delete' => 'Xóa danh mục thành công!',
        ],
        'users' => [
            'create' => 'Tạo người dùng thành công!',
            'edit' => 'Sửa người dùng thành công!',
            'delete' => 'Xóa người dùng thành công!',
            'lock' => 'Khóa người dùng thành công!',
            'unlock' => 'Mở khóa người dùng thành công!',
            'change_password' => 'Đổi mật khẩu người dùng thành công!',
            'check_mail' => 'Vui lòng kiểm tra mail để xác thực mã code!',
            'login_success' => 'Đăng nhập thành công!',
            'forgot_password' => 'Quên mật khẩu thành công, vui lòng kiểm tra Email!',
            'resend_code' => 'Gửi lại mã code thành công!',
            'confirm_success' => 'Xác thực thành công!',
        ],
    ],
    'errors' => [
        'errors' => 'Thất bại!',
        'not_found' => 'Bản ghi không tồn tại!',
        'category' => [
            'create' => 'Tạo danh mục không thành công!',
            'edit' => 'Sửa danh mục không thành công!',
            'delete' => 'Xóa danh mục không mục thành công!',
            'not_found' => 'Danh mục không tồn tại!',
        ],
        'road' => [
            'not_found' => 'Không tìm thấy chuyến xe'
        ],
        'merchandise' => [
            'create' => 'Tạo sản phẩm không thành công!',
            'edit' => 'Sửa sản phẩm không thành công!',
            'delete' => 'Xóa sản phẩm không mục thành công!',
            'not_found' => 'Sản phẩm không tồn tại!',
            'not_permission' => 'Bạn không có quyền sửa sản phẩm này!',
        ],
        'users' => [
            'create' => 'Tạo người dùng không thành công!',
            'edit' => 'Sửa người dùng không thành công!',
            'delete' => 'Xóa người dùng không mục thành công!',
            'not_found' => 'Người dùng không tồn tại!',
            'code' => 'Mã code đã hết hạn hoặc không tồn tại!',
            'email_not_found' => 'Email không tồn tại!',
            'account_not_active' => 'Tài khoản chưa được kích hoạt!',
            'password_not_correct' => 'Mật khẩu không chính xác!',
            'password_old_not_correct' => 'Mật khẩu cũ không chính xác!',
        ],
        'address' => [
            'create' => 'Tạo địa chỉ không thành công!',
            'edit' => 'Sửa địa chỉ không thành công!',
            'delete' => 'Xóa địa chỉ không mục thành công!',
            'not_found' => 'Địa chỉ không tồn tại!',
        ],
        'image' => [
            'not_available' => 'Ảnh không hợp lệ!',
            'required' => 'Vui lòng lựa chọn ảnh cho sản phẩm!',
        ],
        'date' => [
            'not_available' => 'Ngày không hợp lệ!',
        ],
        'chat' => [
            'create' => 'Tạo tin nhắn không thành công!',
            'edit' => 'Sửa tin nhắn không thành công!',
            'delete' => 'Xóa tin nhắn không mục thành công!',
            'not_found' => 'Tin nhắn không tồn tại!',
            'cannot_chat' => 'Bạn không thể nhắn tin với người dùng này!',
        ],
        'rating' => [
            'create' => 'Tạo đánh giá không thành công!',
            'edit' => 'Sửa đánh giá không thành công!',
            'delete' => 'Xóa đánh giá không mục thành công!',
            'not_found' => 'Đánh giá không tồn tại!',
            'rating_self' => 'Không thể tự đánh giá sản phẩm của bản thân!',
        ],
        'transaction' => [
            'create' => 'Tạo giao dịch không thành công!',
            'edit' => 'Sửa giao dịch không thành công!',
            'delete' => 'Xóa giao dịch không mục thành công!',
            'not_found' => 'Giao dịch không tồn tại!',
            'not_permission' => 'Bạn không có quyền tặng sản phẩm!',
            'receiver_required' => 'Vui lòng chọn người tặng!',
            'not_enough' => 'Số lượng đơn hàng không đủ!',
        ],
        'states' => [
            'create' => 'Tạo khu vực không thành công!',
            'edit' => 'Sửa khu vực không thành công!',
            'delete' => 'Xóa khu vực không thành công!',
            'not_found' => 'Không tìm thấy khu vực',
        ],
        'station' => [
            'create' => 'Tạo trạm - chi nhánh không thành công',
            'edit' => 'Sửa trạm - chi nhánh không thành công',
            'delete' => 'Xóa trạm - chi nhánh không thành công',
            'not_found' => 'Trạm - chi nhánh không tồn tại!',
        ],
        'fcm' => [
            'create' => 'Tạo thông báo FCM không thành công',
            'edit' => 'Sửa thông báo FCM không thành công',
            'delete' => 'Xóa thông báo FCM không thành công',
            'not_found' => 'Thông báo FCM không tồn tại!',
            'push_success' => 'Đẩy thông báo FCM thất bại!',
        ],
        'contact' => [
            'not_found' => 'Liên hệ không tồn tại!'
        ],
        'media' => [
            'file_not_found' => 'File không tồn tại!',
            'not_exist_file' => 'Không thể xác định tập tin!',
            'file_too_big' => 'Tập tin quá lớn. Giới hạn tải lên là :size',
            'can_not_identify_file_type' => 'File tải lên phải có định dạng (:values)',
        ],
        'validation' => [
            'uploaded' => 'Quá trình tải file lên lên thất bại.',
            'required' => 'Trường :field không được bỏ trống.',
            'integer' => 'Trường :field phải là số nguyên.',
            'string' => 'Trường :field phải là một chuỗi',
            'max' => 'Trường :field không được vượt quá :values kí tự',
            'in' => 'Trường :field phải là :values',
        ],
        'static_page' => [
            'not_found' => 'Không tồn tại trang tĩnh',
        ],
        'ticket' => [
            'not_found' => 'Vé không tồn tại',
        ],
        'rules' => [
            'required'  => ':attribute là trường bắt buộc.',
            'string'    => ':attribute phải là một chuỗi ký tự.',
            'in'        => 'Giá trị của trường :attribute phải là một trong các giá trị sau: :value',
            'not_in'    => ':attribute đã chọn không hợp lệ.',
            'min'       => ':attribute phải có ít nhất :value ký tự.',
            'url'       => ':attribute phải là địa chỉ URL hợp lệ.',
            'max'       => ':attribute không được vượt quá :value ký tự.',
            'integer'   => ':attribute phải là số nguyên.',
            'mimes'     => ':attribute phải có định dạng là: :value',
            'email'     => ':attribute phải có định dạng email.',
            'unique'    => ':attribute đã tồn tại.',
            'json'      => ':attribute phải là một chuỗi JSON hợp lệ.',
            'image'     => ':attribute phải là hình ảnh.',
            'array'     => 'Trường :attribute phải là một dãy giá trị.',
            'boolean'   => 'Trường :attribute phải có thể chuyển đổi thành true hoặc false.',
            'regex'     => ':attribute không đúng định dạng.',
            'exist'     => ':attribute không tồn tại.',
            'same'      => ':attribute và :other phải giống nhau.',
            'uploaded'  => 'Không thể tải tệp lên.',
            'numeric'   => ':attribute phải là số.',
            'after'     => ':attribute phải lớn hơn :value.',
            'date'        => 'Trường :attribute phải là ngày hợp lệ.',
            'date_format' => 'Trường :attribute phải theo định dạng :value.'
        ],
        'promotion' => [
            'not_found' => 'Khuyến mãi không tồn tại',
            'percent-min' => 'Giảm giá nhỏ nhất bằng 0%',
            'percent-max' => 'Giảm giá lớn nhất bằng 100%',
            'max_discount-min' => 'Giá tiền nhỏ nhất bằng 0',
        ],
        'notification'=>[
            'not_found' => 'Thông báo không tồn tại!'
        ]
    ]
];
