<?php

return [
    'success' => [
        'success' => 'Success!',
        'category' => [
            'create' => 'Create category success!',
            'edit' => 'Edit category success!',
            'delete' => 'Delete category success!',
        ],
        'road' => [
            'delete' => 'Delete road succsess',
        ],
        'merchandise' => [
            'create' => 'Create merchandise success!',
            'edit' => 'Edit merchandise success!',
            'delete' => 'Delete merchandise success!',
        ],
        'users' => [
            'create' => 'Create user success!',
            'edit' => 'Edit user success!',
            'delete' => 'Delete user success!',
            'lock' => 'Lock user success!',
            'unlock' => 'Unlock user success!',
            'change_password' => 'Change password user success!',
            'check_mail' => 'Please check your email to verify the code!',
            'login_success' => 'Login success!',
            'forgot_password' => 'Forgot password successfully, please check your Email!',
            'resend_code' => 'Forgot password successfully, please check your Email!',
            'confirm_success' => 'Authentication successful!',
        ],
        'address' => [
            'create' => 'Create address success!',
            'edit' => 'Edit address success!',
            'delete' => 'Delete address success!',
        ],
        'chat' => [
            'create' => 'Create message success!',
            'edit' => 'Edit message success!',
            'delete' => 'Delete message success!',
        ],
        'states' => [
            'create' => 'Create states success!',
            'edit' => 'Edit states success!',
            'delete' => 'Delete states success!',
        ],
        'contact' => [
            'delete' => 'Delete contact success!',
            'created' => 'Add contact success!',
        ],
        'promotion' => [
            'create' => 'Create promotion success',
            'edit' => 'Edit promotion success',
            'delete' => 'Delete promotion success',
        ],
        'fcm' => [
            'create' => 'Create FCM notify success',
            'edit' => 'Edit FCM notify success',
            'delete' => 'Delete FCM notify success',
            'push_success' => 'Push FCM notify success!',
        ]
    ],
    'errors' => [
        'errors' => 'Failed!',
        'not_found' => 'Record does not exist!',
        'category' => [
            'create' => 'Create category failed!',
            'edit' => 'Edit category failed!',
            'delete' => 'Delete category failed!',
            'not_found' => 'The category does not exist!',
        ],
        'road' => [
            'not_found' => 'The road not found'
        ],
        'merchandise' => [
            'create' => 'Create merchandise failed!',
            'edit' => 'Edit merchandise failed!',
            'delete' => 'Delete merchandise failed!',
            'not_found' => 'The merchandise not found!',
            'not_permission' => 'You are not authorized to edit this merchandise!',
        ],
        'users' => [
            'create' => 'Create user failed!',
            'edit' => 'Edit user failed!',
            'delete' => 'Delete user failed!',
            'not_found' => 'The user not found!',
            'code' => 'The code has expired or does not exist!',
            'email_not_found' => 'The email not exist!',
            'account_not_active' => 'Account not active!',
            'password_not_correct' => 'The password is not correct!',
            'password_old_not_correct' => 'The old password is not correct!',
        ],
        'address' => [
            'create' => 'Create address failed!',
            'edit' => 'Edit address failed!',
            'delete' => 'Delete address failed!',
            'not_found' => 'The address is not found!',
        ],
        'image' => [
            'not_available' => 'The image is not available!',
            'required' => 'Please choose a photo for the product!',
        ],
        'date' => [
            'not_available' => 'The date is not available!',
        ],
        'chat' => [
            'create' => 'Create message failed!',
            'edit' => 'Edit message failed!',
            'delete' => 'Delete message failed!',
            'not_found' => 'The messages is not exist!',
            'cannot_chat' => 'You cannot message this user!',
        ],
        'rating' => [
            'create' => 'Create rating failed!',
            'edit' => 'Edit rating failed!',
            'delete' => 'Delete rating failed!',
            'not_found' => 'The rating is not exist!',
            'rating_self' => 'Cant rate self own product!',
        ],
        'transaction' => [
            'create' => 'Create transaction failed!',
            'edit' => 'Edit transaction failed!',
            'delete' => 'Delete transaction failed!',
            'not_found' => 'The transaction is not exist!',
            'not_permission' => 'You do not have the right to donate the product!',
            'receiver_required' => 'Please choose recipient!',
            'not_enough' => 'The order quantity is not enough!',
        ],

        'states' => [
            'create' => 'Create stationstates failed!',
            'edit' => 'Edit states failed!',
            'delete' => 'Delete states failed!',
            'not_found' => 'The states is not exist!',
        ],

        'fcm' => [
            'create' => 'Create FCM notify failed!',
            'edit' => 'Edit FCM notify failed!',
            'delete' => 'Delete FCM notify failed!',
            'not_found' => 'The FCM notify is not exist!',
            'push_error' => 'Push FCM notify error!',
        ],
        'media' => [
            'file_not_found' => 'File not found!',
            'not_exist_file' => 'Unable to determine the file!',
            'file_too_big' => 'The file is too large. The upload limit is :size',
            'can_not_identify_file_type' => 'Uploaded file must have the format(s): :values',
        ],
        'validation' => [
            'uploaded' => 'Failed to upload the file.',
            'required' => 'The :field field is required.',
            'integer' => 'The :field field must be an integer.',
            'string' => 'The :field field must be a string.',
            'max' => 'The :field field must not exceed :values characters.',
            'in' => 'The :field field must be either :values'
        ],
        'contact' => [
            'not_found' => 'Contact not exist!'
        ],
        'rules' => [
            'required'    => ':attribute is required',
            'string'      => 'Value for :attribute must be string.',
            'in'          => 'The :attribute field must be either :value',
            'not_in'      => 'The selected :attribute: is invalid',
            'min'         => 'Minimal value for :attribute is :value',
            'url'         => 'Key :attribute must be valid url',
            'max'         => 'Maximal value for :attribute is :value',
            'integer'     => 'Value for :attribute must be integer.',
            'mimes'       => 'Allowed formats for :attribute: :value',
            'email'       => ':attribute must have email format',
            'unique'      => ':attribute already exists',
            'json'        => ':attribute must be a valid JSON string',
            'image'       => ':attribute must be an image.',
            'array'       => 'The :attribute must be array.',
            'boolean'     => 'The :attribute must be able to be cast as a boolean. Accepted input are true, false, 1 and 0.',
            'regex'       => 'The :attribute: format is invalid',
            'exist'       => 'The :attribute: doesn\'t exist',
            'same'        => 'The :attribute and :value must match',
            'uploaded'    => 'Failed to upload the file.',
            'numeric'     => 'Key :attribute must be numeric',
            'invalid_key' => 'Invalid data for :attribute',
            'after'       => ':attribute must be greater than :other.',
            'date'        => 'The :attribute must be a valid date.',
            'date_format' => 'The :attribute must be in the :value.'
        ],
        'promotion' => [
            'not_found' => 'This promotion is not exist',
            'min' => 'Minimal value is 0',
            'max' => 'Maximal value is 100',
        ],
        'notification'=>[
            'not_found' => 'This notification does not exist!'
        ]
    ]
];
