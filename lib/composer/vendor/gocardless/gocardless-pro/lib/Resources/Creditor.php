<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Resources;

/**
 * A thin wrapper around a creditor, providing access to it's
 * attributes
 *
 * @property-read $address_line1
 * @property-read $address_line2
 * @property-read $address_line3
 * @property-read $city
 * @property-read $country_code
 * @property-read $created_at
 * @property-read $id
 * @property-read $links
 * @property-read $name
 * @property-read $postal_code
 * @property-read $region
 */
class Creditor extends BaseResource
{
    protected $model_name = "Creditor";

    /**
     * The first line of the creditor's address.
     */
    protected $address_line1;

    /**
     * The second line of the creditor's address.
     */
    protected $address_line2;

    /**
     * The third line of the creditor's address.
     */
    protected $address_line3;

    /**
     * The city of the creditor's address.
     */
    protected $city;

    /**
     * [ISO
     * 3166-1](http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements)
     * alpha-2 code.
     */
    protected $country_code;

    /**
     * Fixed [timestamp](#overview-time-zones-dates), recording when this
     * resource was created.
     */
    protected $created_at;

    /**
     * Unique identifier, beginning with "CR".
     */
    protected $id;

    /**
     * 
     */
    protected $links;

    /**
     * The creditor's name.
     */
    protected $name;

    /**
     * The creditor's postal code.
     */
    protected $postal_code;

    /**
     * The creditor's address region, county or department.
     */
    protected $region;

}
