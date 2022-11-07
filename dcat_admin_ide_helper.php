<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection idjob
     * @property Grid\Column|Collection job_code
     * @property Grid\Column|Collection jobdescription
     * @property Grid\Column|Collection company
     * @property Grid\Column|Collection jobtypeKey
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection meta
     * @property Grid\Column|Collection idtranslator
     * @property Grid\Column|Collection othertranslator
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection attn
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection idtranslation
     * @property Grid\Column|Collection task_id
     * @property Grid\Column|Collection lx_number
     * @property Grid\Column|Collection invoiceCode
     * @property Grid\Column|Collection InvoiceNo
     * @property Grid\Column|Collection ApproveId
     * @property Grid\Column|Collection Transtatus
     * @property Grid\Column|Collection InvoiceTime
     * @property Grid\Column|Collection tranRemark
     * @property Grid\Column|Collection total
     * @property Grid\Column|Collection invoiceDate
     * @property Grid\Column|Collection reviseDate
     * @property Grid\Column|Collection words
     * @property Grid\Column|Collection pages
     * @property Grid\Column|Collection other
     * @property Grid\Column|Collection less
     * @property Grid\Column|Collection lx_code
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection expires_at
     * @property Grid\Column|Collection vender_id
     * @property Grid\Column|Collection items
     * @property Grid\Column|Collection client_id
     * @property Grid\Column|Collection lx_no
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection job_in_date
     * @property Grid\Column|Collection publish_date
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection idjob(string $label = null)
     * @method Grid\Column|Collection job_code(string $label = null)
     * @method Grid\Column|Collection jobdescription(string $label = null)
     * @method Grid\Column|Collection company(string $label = null)
     * @method Grid\Column|Collection jobtypeKey(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection meta(string $label = null)
     * @method Grid\Column|Collection idtranslator(string $label = null)
     * @method Grid\Column|Collection othertranslator(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection attn(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection idtranslation(string $label = null)
     * @method Grid\Column|Collection task_id(string $label = null)
     * @method Grid\Column|Collection lx_number(string $label = null)
     * @method Grid\Column|Collection invoiceCode(string $label = null)
     * @method Grid\Column|Collection InvoiceNo(string $label = null)
     * @method Grid\Column|Collection ApproveId(string $label = null)
     * @method Grid\Column|Collection Transtatus(string $label = null)
     * @method Grid\Column|Collection InvoiceTime(string $label = null)
     * @method Grid\Column|Collection tranRemark(string $label = null)
     * @method Grid\Column|Collection total(string $label = null)
     * @method Grid\Column|Collection invoiceDate(string $label = null)
     * @method Grid\Column|Collection reviseDate(string $label = null)
     * @method Grid\Column|Collection words(string $label = null)
     * @method Grid\Column|Collection pages(string $label = null)
     * @method Grid\Column|Collection other(string $label = null)
     * @method Grid\Column|Collection less(string $label = null)
     * @method Grid\Column|Collection lx_code(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection expires_at(string $label = null)
     * @method Grid\Column|Collection vender_id(string $label = null)
     * @method Grid\Column|Collection items(string $label = null)
     * @method Grid\Column|Collection client_id(string $label = null)
     * @method Grid\Column|Collection lx_no(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection job_in_date(string $label = null)
     * @method Grid\Column|Collection publish_date(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection idjob
     * @property Show\Field|Collection job_code
     * @property Show\Field|Collection jobdescription
     * @property Show\Field|Collection company
     * @property Show\Field|Collection jobtypeKey
     * @property Show\Field|Collection status
     * @property Show\Field|Collection meta
     * @property Show\Field|Collection idtranslator
     * @property Show\Field|Collection othertranslator
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection attn
     * @property Show\Field|Collection email
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection address
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection idtranslation
     * @property Show\Field|Collection task_id
     * @property Show\Field|Collection lx_number
     * @property Show\Field|Collection invoiceCode
     * @property Show\Field|Collection InvoiceNo
     * @property Show\Field|Collection ApproveId
     * @property Show\Field|Collection Transtatus
     * @property Show\Field|Collection InvoiceTime
     * @property Show\Field|Collection tranRemark
     * @property Show\Field|Collection total
     * @property Show\Field|Collection invoiceDate
     * @property Show\Field|Collection reviseDate
     * @property Show\Field|Collection words
     * @property Show\Field|Collection pages
     * @property Show\Field|Collection other
     * @property Show\Field|Collection less
     * @property Show\Field|Collection lx_code
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection expires_at
     * @property Show\Field|Collection vender_id
     * @property Show\Field|Collection items
     * @property Show\Field|Collection client_id
     * @property Show\Field|Collection lx_no
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection job_in_date
     * @property Show\Field|Collection publish_date
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection idjob(string $label = null)
     * @method Show\Field|Collection job_code(string $label = null)
     * @method Show\Field|Collection jobdescription(string $label = null)
     * @method Show\Field|Collection company(string $label = null)
     * @method Show\Field|Collection jobtypeKey(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection meta(string $label = null)
     * @method Show\Field|Collection idtranslator(string $label = null)
     * @method Show\Field|Collection othertranslator(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection attn(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection idtranslation(string $label = null)
     * @method Show\Field|Collection task_id(string $label = null)
     * @method Show\Field|Collection lx_number(string $label = null)
     * @method Show\Field|Collection invoiceCode(string $label = null)
     * @method Show\Field|Collection InvoiceNo(string $label = null)
     * @method Show\Field|Collection ApproveId(string $label = null)
     * @method Show\Field|Collection Transtatus(string $label = null)
     * @method Show\Field|Collection InvoiceTime(string $label = null)
     * @method Show\Field|Collection tranRemark(string $label = null)
     * @method Show\Field|Collection total(string $label = null)
     * @method Show\Field|Collection invoiceDate(string $label = null)
     * @method Show\Field|Collection reviseDate(string $label = null)
     * @method Show\Field|Collection words(string $label = null)
     * @method Show\Field|Collection pages(string $label = null)
     * @method Show\Field|Collection other(string $label = null)
     * @method Show\Field|Collection less(string $label = null)
     * @method Show\Field|Collection lx_code(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection expires_at(string $label = null)
     * @method Show\Field|Collection vender_id(string $label = null)
     * @method Show\Field|Collection items(string $label = null)
     * @method Show\Field|Collection client_id(string $label = null)
     * @method Show\Field|Collection lx_no(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection job_in_date(string $label = null)
     * @method Show\Field|Collection publish_date(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
