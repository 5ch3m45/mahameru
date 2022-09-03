<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2019 - 2022, CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @copyright	Copyright (c) 2019 - 2022, CodeIgniter Foundation (https://codeigniter.com/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']		= 'Kolom {field} harus diisi';
$lang['form_validation_isset']			= 'Kolom {field} harus memiliki nilai';
$lang['form_validation_valid_email']		= 'Kolom {field} harus berisi email yang valid';
$lang['form_validation_valid_emails']		= 'Kolom {field} harus berisi email-email yang valid';
$lang['form_validation_valid_url']		= 'Kolom {field} harus berisi URL yang valid';
$lang['form_validation_valid_ip']		= 'Kolom {field} harus berisi IP yang valid';
$lang['form_validation_valid_base64']		= 'Kolom {field} harus berisi Base64';
$lang['form_validation_min_length']		= 'Kolom {field} harus berisi minimai {param} karakter';
$lang['form_validation_max_length']		= 'Kolom {field} tidak boleh lebih dari {param} karakter';
$lang['form_validation_exact_length']		= 'Kolom {field} harus berisi {param} karakter';
$lang['form_validation_alpha']			= 'Kolom {field} hanya boleh berisi karakter alfabet';
$lang['form_validation_alpha_numeric']		= 'Kolom {field} hanya boleh berisi karakter alpha-numeric';
$lang['form_validation_alpha_numeric_spaces']	= 'Kolom {field} hanya boleh berisi karakter alpha-numeric dan spasi';
$lang['form_validation_alpha_dash']		= 'Kolom {field} hanya boleh berisi karakter alpha-numeric, garis bawah (_), dan strip (-)';
$lang['form_validation_numeric']		= 'Kolom {field} hanya boleh berisi angka';
$lang['form_validation_is_numeric']		= 'Kolom {field} hanya boleh berisi karakter numeric';
$lang['form_validation_integer']		= 'Kolom {field} hanya bileh berisi integer';
$lang['form_validation_regex_match']		= 'Format kolom {field} tidak valid';
$lang['form_validation_matches']		= 'Kolom {field} tidak sama dengan kolom {param}';
$lang['form_validation_differs']		= 'Kolom {field} harus berbeda dengan kolom {param}';
$lang['form_validation_is_unique'] 		= 'Kolom {field} harus unik';
$lang['form_validation_is_natural']		= 'Kolom {field} hanya boleh berisi digit';
$lang['form_validation_is_natural_no_zero']	= 'Kolom {field} hanya boleh berisi digit dan harus lebih dari nol (0)';
$lang['form_validation_decimal']		= 'Kolom {field} hanya boleh berisi angka desimal';
$lang['form_validation_less_than']		= 'Kolom {field} hanya boleh berisi angka kurang dari {param}';
$lang['form_validation_less_than_equal_to']	= 'Kolom {field} hanya boleh berisi angka kurang dari atau sama dengan {param}';
$lang['form_validation_greater_than']		= 'Kolom {field} hanya boleh berisi angka lebih dari {param}';
$lang['form_validation_greater_than_equal_to']	= 'Kolom {field} hanya boleh berisi angka lebih dari atau sama dengan {param}';
$lang['form_validation_error_message_not_set']	= 'Tidak dapat mengakses pesan error karena kolom {field} tidak valid';
$lang['form_validation_in_list']		= 'Kolom {field} harus berisi salah satu dari: {param}';
