@extends('layouts.app')
<style>
    .list-group {
        padding: 20px!important;
    }
    .my-ul {
        list-style-type: disc !important;
        padding-left:1em !important;
        margin-left:1em;
    }
</style>
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <h3 class="text-center">{{ __('text.refund_and_return') }}</h3>
                <br>
                <br>
                <p>RETURN POLICY, REFUND, CANCELLATION AND SHIPPING CHARGES POLICY</p>
                <p>Subidha facilitates processing correct medicines as per order and prescription and strives to service the medicines and products in right conditions/ without any damage every time a consumer places an order. We also strongly recommend the items are checked at the time of delivery.</p>
                <ol class="list-group" type="1">
                    <h3><li>DEFINITION</li></h3>
                    <p>'Return' means an action of giving back the product ordered at subidha portal by the consumer. The following situations may arise which may cause the action of return of product:</p>
                    <ol class="list-group" type="1">
                        <li>Product(s) delivered do not match your order;</li>
                        <li>Product(s) delivered are past or near to its expiry date (medicines with an expiry date of less than 02 months shall be considered as near expiry);</li>
                        <li>Product(s) are physician sample which are not for sale; </li>
                        <li>Product(s) delivered were damaged in transit (do not to accept any product which has a tampered seal):</li>
                    </ol>
                    <p><b>Note: If the product that you have received is damaged, then do not accept the delivery of that product. If after opening the package you discover that the product is damaged, the same may be returned for a refund. Please note that we cannot promise a replacement for all products as it will depend on the availability of the particular product, in such cases we will offer a refund. </b></p>
                    <p><b>In the aforesaid unlikely situations, if there is something wrong with the order, we'd be happy to assist and resolve your concern. You may raise a Return request with our customer care within 03 (Three) days from the delivery of the product. Subidha reserves the right to cancel the Return request, if the customer reaches out to Subidha after 3 days of delivery. </b></p>
                    <p><b>Upon receiving your Return/Refund request, Subidha shall verify the authenticity and the nature of the request. If Subidha finds that the request is genuine, it will initiate the Return and Refund process. Subidha shall process the refund only once it has received the confirmation from the vendor concerned in respect of the contents of the product relating to that refund. </b></p>
                    <p><b>In the event of frivolous and unjustified complaints regarding the quality and content of the products, Subidha reserves the right to pursue necessary legal actions against you and you will be solely liable for all costs incurred by Subidha in this regard.
                        </b></p>
                    <p><b>The returns are subject to the below conditions:-
                        </b></p>
                    <ol class="list-group" type="1">
                        <li>Any wrong ordering of product doesn’t qualify for Return;</li>
                        <li>Return requests arising due to change in prescription do not qualify for Return;</li>
                        <li>Product being returned should only be in their original manufacturer's packaging and </li>
                        <li>Partially consumed strips or products do not qualify for Return, only fully unopened strips or products can be returned. </li>
                        <br>
                        <p><b>Category of Non-Returnable Product:Certain categories of products marked as non- returnable on product page, will not qualify for the Return as per Subidha Return policy. The details of the non- returnable products are mentioned below: </b></p>
                        <table class="table table-bordered">
                            <thead>
                            <th>Categories</th>
                            <th>Type of Products</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Baby Care</td>
                                <td>Bottle Nipples, Breast Nipple Care, Breast Pumps, Diapers, Ear Syringes, Diapers, Wipes and this type of items</td>
                            </tr>
                            <tr>
                                <td>Food and Nutrition</td>
                                <td>Health Drinks, Health Supplements</td>
                            </tr>
                            <tr>
                                <td>Healthcare Devices</td>
                                <td>Glucometer Lancet/Strip, Healthcare Devices and Kits, Surgical, Health Monitors</td>
                            </tr>
                            <tr>
                                <td>Sexual Wellness</td>
                                <td>Condoms, Fertility Kit/Supplement, Lubricants, Pregnancy Kits</td>
                            </tr>
                            <tr>
                                <td>Temperature Controlled and Speciality Medicines</td>
                                <td>Vials, Injections, Vaccines, Penfills and any other Product, requiring cold storage, or medicines that fall under the category of speciality medicines.</td>
                            </tr>
                            </tbody>
                        </table>
                    </ol>
                    <h3><li>RETURN PROCESS:</li></h3>
                    <ol class="list-group" type="1">
                        <b><li>Subidha customer care team will verify the claim made by the customer within 72 (seventy-two) business hours from the time of receipt of complaint.
                            </li></b>
                        <b><li>Once the claim is verified as genuine and reasonable, Subidha will initiate the collection of product(s) to be returned or You may be advised to contact our Third Party Pharmacy.</li></b>
                        <b><li>The customer will be required to pack the product(s) in original manufacturer’s packaging.</li></b>
                        <b><li>Refund will be completed within 30 (thirty) days from date of reverse pick up (if required).</li></b>
                    </ol>
                    <h3><li>REFUND PROCESS:</li></h3>
                    <p><b>In all the above cases, if the claim is found to be valid, Refund will be made as mentioned below:</b></p>
                    <p><b>Order will be refunded through fund transfer to customer bank account or other applicable source.</b></p>
                    <h3><li>CANCELLATION POLICY:</li></h3>
                    <p><b>Customer cancellation:</b></p>
                    <p><b>The customer can cancel the order for the product till Subidha ship it. Orders once shipped cannot be cancelled. </b></p>
                    <p><b>Subidha cancellation:</b></p>
                    <p><b>There may be certain orders that Subidha partners are unable to accept and service and these may need to be cancelled. Some situations that may result in your order being cancelled include, non-availability of the product or quantities ordered by you</b></p>
                    <p><b>Subidha also reserves the right to cancel any orders that classify as ‘Bulk Order’ as determined by Subidha as per certain criteria. An order can be classified as ‘Bulk Order’ if it meets with the below mentioned criteria, which may not be exhaustive: </b></p>
                    <ol class="list-group" type="i">
                        <b><li>Products ordered are not for self-consumption but for commercial resale;</li></b>
                        <b><li>Multiple orders placed for same product at the same address;</li></b>
                        <b><li>Bulk quantity of the same product ordered;</li></b>
                        <b><li>Invalid address given in order details;</li></b>
                        <b><li>Any malpractice used to place the order.</li></b>
                    </ol>
                </ol>
            </div>
        </div>
    </div>
@endsection
