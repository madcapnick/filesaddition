<!--
	Sliced Invoices Custom Client Area Template WITH User Files Functionality
	Template Developed By: Nick Mabee, madcap creative
	Website: https://madcapmn.co
	
	Credits:
	Sliced Invoices Plugin v3.7.5
		Author:            Sliced Invoices
		Author URI:        http://slicedinvoices.com/
	User Private Files Plugin v1.1
		Author: Hai Bui - FLDtrace team
		Author URI: http://www.fldtrace.com
	
	DIRECTIONS FOR USE: 
	1) Install Sliced Invoices Plugin as well as Client Area Extention directly from Sliced Invoices here: https://slicedinvoices.com/
	2) Install the "User Private Files" plugin from here: https://github.com/fldtrace/user-private-files-plugin
	3) Activate both plugins on same website, set up Simple Invoices Plugin as normal, set up Client Area plugin as normal. Activate "User Private Files" Plugin
	4) Create and copy/paste or insert this PHP file into your theme folder /YOURTHEME/Sliced/client-area.php
	
-->

<?php 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
$inv_label_plural = sliced_get_invoice_label_plural();
$inv_label = sliced_get_invoice_label();
$quo_label_plural = sliced_get_quote_label_plural();
$quo_label = sliced_get_quote_label();
?>

    <div class="sliced client">

        <?php do_action( 'sliced_before_client_area' ) ?>
        <div class="sliced-client-snapshot">
               <h4><i class="fa fa-camera-retro"></i> <?php echo sliced_get_client_label( 'client-accountsnapshot-label', 'Account Snapshot' ); ?></h4>
        <div class="row sliced-upper">

            <div class="sliced-to-address sliced-address">
<table width="100%" border="0" cellspacing="0">
<tr>
<td width="50%">
                <div class="name"><?php echo esc_html( sliced_get_client_business() ); ?></div>
                <?php echo sliced_get_client_address() ? 
                    '<div class="address">' . wpautop( wp_kses_post( sliced_get_client_address() ) ) . '</div>' : ''; ?>
                <?php echo sliced_get_client_extra_info() ? 
                    '<div class="extra_info">' . wpautop( wp_kses_post( sliced_get_client_extra_info() ) ) . '</div>' : ''; ?>
                <?php echo sliced_get_client_website() ? 
                    '<div class="website">' . esc_html( sliced_get_client_website() ) . '</div>' : ''; ?>
                <?php echo sliced_get_client_email() ? 
                    '<div class="email">' . esc_html( sliced_get_client_email() ) . '</div>' : ''; ?>
				</div>
</td>
<td width="50%">
            <table width="100%" border="0" cellspacing="0">
			<tr>
			<td>
				<?php if ( ! sliced_client_area_hide_quotes() ):?>
                <div class="owing">
                    <span class="amount sent"><?php echo esc_html( sliced_get_quote_totals( 'sent' ) ); ?></span> 
                    <?php echo sliced_get_client_label( 'client-quotespending-label', 'Quotes Pending' ); ?></div>
                <div class="small">
                    <span class="count"><?php echo count( sliced_user_items_ids( 'quote' ) ); ?></span>
                    <?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $quo_label_plural ); ?>,
                    <span class="count"><?php echo esc_html( sliced_get_quote_count( 'sent' ) ); ?></span> <?php echo sliced_get_client_label( 'client-awaitingresponse-label', 'awaiting response' ); ?>
                </div>
				<?php endif; ?>
			</td>
			<td>
				<?php if ( ! sliced_client_area_hide_invoices() ):?>
                <div class="owing">
                    <span class="amount unpaid"><?php echo esc_html( sliced_get_invoice_totals( array( 'unpaid', 'overdue' ) ) ); ?></span> 
                    <?php echo sliced_get_client_label( 'client-totaloutstanding-label', 'Total Outstanding' ); ?></div>                

                <div class="small">
                    <span class="count"><?php echo count( sliced_user_items_ids( 'invoice' ) ); ?></span> <?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $inv_label_plural ); ?>,
                    <span class="count"><?php echo esc_html( sliced_get_invoice_count( array( 'unpaid', 'overdue' ) ) ); ?></span> <?php echo sliced_get_client_label( 'client-awaitingpayment-label', 'awaiting payment' ); ?>
                </div>
				<?php endif; ?>
			</tr>
			</table>
			</td>
			</tr>
			</table>
            </div>
            
        </div>

        <hr>

		<?php if ( ! sliced_client_area_hide_quotes() ):?>
		
        <!-- QUOTES ////////////// -->
        <div class="row sliced-quote-items sliced-items">
            
            <div class="col-sm-12">

            <h3><i class="fa fa-pie-chart"></i> <?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $quo_label_plural ); ?></h3>

                <div class="quote-statuses statuses">
                    <span class="sent"><?php echo sliced_get_client_label( 'sent', __( 'Sent', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_quote_totals( 'sent' ) ); ?></span>
					<?php if ( sliced_get_quote_count( 'accepted' ) > 0 ): ?>
					<span class="accepted"><?php echo sliced_get_client_label( 'accepted', __( 'Accepted', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_quote_totals( 'accepted' ) ); ?></span>
					<?php endif; ?>
                    <span class="declined"><?php echo sliced_get_client_label( 'declined', __( 'Declined', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_quote_totals( 'declined' ) ); ?></span>
                    <span class="cancelled"><?php echo sliced_get_client_label( 'cancelled', __( 'Cancelled', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_quote_totals( 'cancelled' ) ); ?></span>
                </div>
               
            <!-- QUOTES TABLE ////////////// -->    
			<?php $quotes = sliced_user_items_ids( 'quote' );
            if( $quotes ) : ?>
                <div class="table-responsive">
                <table id="table-quotes" class="table table-sm table-bordered table-striped display" cellspacing="0" width="100%">
                    
                    <thead>
                        <tr>
                            <th class="id hidden">ID</th>
                            <th class="date"><strong><?php echo sliced_get_client_label( 'client-date-label', __( 'Date', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="title"><strong><?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $quo_label ); ?></strong></th>
                            <th class="status"><strong><?php echo sliced_get_client_label( 'client-status-label', __( 'Status', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="number"><strong><?php echo sliced_get_client_label( 'client-number-label', __( 'Number', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="totals"><strong><?php echo sliced_get_client_label( 'total', __( 'Total', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="actions"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="id hidden">ID</th>
                            <th class="date"><strong><?php echo sliced_get_client_label( 'client-date-label', __( 'Date', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="title"><strong><?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $quo_label ); ?></strong></th>
                            <th class="status"><strong><?php echo sliced_get_client_label( 'client-status-label', __( 'Status', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="number"><strong><?php echo sliced_get_client_label( 'client-number-label', __( 'Number', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="totals"><strong><?php echo sliced_get_client_label( 'total', __( 'Total', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="actions" data-orderable="false"></th>
                        </tr>
                    </tfoot>

                    <tbody>

                    <?php
                    $count = 0;
                    foreach ( $quotes as $quote ) {
                        $class = ($count % 2 == 0) ? 'even' : 'odd'; ?>

                        <tr class="row_<?php echo esc_attr( $class ); ?> sliced-item">
                            <td class="id hidden"><?php echo esc_html( $quote ); ?></td>
                            <td class="date" data-order="<?php echo esc_attr( sliced_get_created( $quote ) ); ?>"><?php echo sliced_get_created( $quote ) ? esc_html( date_i18n( get_option( 'date_format' ), sliced_get_created( $quote ) ) ) : __( 'N/A', 'sliced-invoices-client-area' ); ?></td>
                            <td class="title"><?php echo esc_html( get_the_title( $quote ) ); ?></td>
                            <td class="status"><span class="<?php echo sanitize_title( sliced_get_quote_status( $quote ) ); ?>"><?php echo esc_html( sliced_get_client_label( sliced_get_quote_status( $quote ), __( sliced_get_quote_status( $quote ), 'sliced-invoices' ) ) ); ?></span></td>
                            <td class="number"><?php echo esc_html( sliced_get_prefix( $quote ) . sliced_get_number( $quote ) ); ?></td>
                            <td class="totals"><?php echo esc_html( sliced_get_quote_total( $quote ) ); ?></td>
                            <td class="actions text-right">
                                <a href="<?php esc_url( the_permalink( $quote ) ); ?>" class="btn btn-default btn-sm"><?php echo sliced_get_client_label( 'client-viewquote-label', 'View Quote' ); ?></a>
                            </td>
                        </tr>

                    <?php $count++; } ?>

                    </tbody>

                </table>
                </div>
                <script type="text/javascript" charset="utf-8">
                    jQuery(document).ready(function() {

                        var title = '<?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $quo_label_plural ) ?><?php echo sanitize_file_name( date_i18n( get_option( 'date_format' ), time() ) ) ?>';

                        jQuery('#table-quotes').DataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "pageLength": 10,
                            buttons: [
                                { extend: 'copy', text: '<i class="fa fa-copy"></i> <?php echo sliced_get_client_label( 'client-copy-label', 'Copy' ); ?>', title: title, exportOptions: { columns: [1,2,3,4,5,6] }  },
                                { extend: 'csv', text: '<i class="fa fa-file-excel-o"></i> CSV', title: title, exportOptions: { columns: [1,2,3,4,5,6] }  },
                                { extend: 'pdf', text: '<i class="fa fa-file-pdf-o"></i> PDF', title: title, exportOptions: { columns: [1,2,3,4,5,6] } },
                            ],
                            "dom": "<'row'<'col-sm-12 search'f>>t<'row'<'col-sm-8' B><'col-sm-4'lp>><'clear'>",
							"oLanguage": {
								"sSearch": "<?php echo sliced_get_client_label( 'client-search-label', 'Search' ); ?>",
								"oPaginate": {
									"sPrevious": "<?php echo sliced_get_client_label( 'client-previous-label', 'Previous' ); ?>",
									"sNext": "<?php echo sliced_get_client_label( 'client-next-label', 'Next' ); ?>"
								}
							},
                        });
                    } );
                </script>

            <?php else : ?>
                <p class="none"><?php echo sliced_get_client_label( 'client-currentlynoquotes-label', 'Currently no Quotes' ); ?></p> 
            <?php endif; ?>

            </div>

        </div>

        <hr>
		
		<?php endif; ?>

		<?php if ( ! sliced_client_area_hide_invoices() ):?>
		
        <!-- INVOICES ////////////// -->
        <div class="row sliced-invoice-items sliced-items">
            
            <div class="col-sm-12">

            <h3><i class="fa fa-pie-chart"></i> <?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $inv_label_plural ); ?></h3>

                <div class="invoice-statuses statuses">
                    <span class="paid"><?php echo sliced_get_client_label( 'paid', __( 'Paid', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_invoice_totals( 'paid' ) ); ?></span>
                    <span class="unpaid"><?php echo sliced_get_client_label( 'unpaid', __( 'Unpaid', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_invoice_totals( 'unpaid' ) ); ?></span>
                    <span class="overdue"><?php echo sliced_get_client_label( 'overdue', __( 'Overdue', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_invoice_totals( 'overdue' ) ); ?></span>
                    <span class="cancelled"><?php echo sliced_get_client_label( 'cancelled', __( 'Cancelled', 'sliced-invoices' ) ); ?> <?php echo esc_html( sliced_get_invoice_totals( 'cancelled' ) ); ?></span>
                </div>
        
            <!-- INVOICES TABLE ////////////// -->        
            <?php $invoices = sliced_user_items_ids( 'invoice' );
            if( $invoices ) : ?>
                <div class="table-responsive">
                <table id="table-invoices" class="table table-sm table-bordered table-striped display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="id hidden">ID</th>
                            <th class="date"><strong><?php echo sliced_get_client_label( 'client-date-label', __( 'Date', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="due"><strong><?php echo sliced_get_client_label( 'client-due-label', __( 'Due', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="title"><strong><?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $inv_label ); ?></strong></th>
                            <th class="status"><strong><?php echo sliced_get_client_label( 'client-status-label', __( 'Status', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="number"><strong><?php echo sliced_get_client_label( 'client-number-label', __( 'Number', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="totals"><strong><?php echo sliced_get_client_label( 'total', __( 'Total', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="actions" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="id hidden">ID</th>
                            <th class="date"><strong><?php echo sliced_get_client_label( 'client-date-label', __( 'Date', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="due"><strong><?php echo sliced_get_client_label( 'client-due-label', __( 'Due', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="title"><strong><?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $inv_label ); ?></strong></th>
                            <th class="status"><strong><?php echo sliced_get_client_label( 'client-status-label', __( 'Status', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="number"><strong><?php echo sliced_get_client_label( 'client-number-label', __( 'Number', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="totals"><strong><?php echo sliced_get_client_label( 'total', __( 'Total', 'sliced-invoices' ) ); ?></strong></th>
                            <th class="actions"></th>
                        </tr>
                    </tfoot>

                    <tbody>

                    <?php
                    $count = 0;
                    foreach ( $invoices as $invoice ) {
                        $class = ($count % 2 == 0) ? 'even' : 'odd'; ?>

                        <tr class="row_<?php echo $class; ?> sliced-item">
                            <td class="id hidden"><?php echo esc_html( $invoice ); ?></td>
                            <td class="date" data-order="<?php echo esc_attr( sliced_get_created( $invoice ) ); ?>"><?php echo sliced_get_created( $invoice ) ? esc_html( date_i18n( get_option( 'date_format' ), sliced_get_created( $invoice ) ) ) :  __( 'N/A', 'sliced-invoices-client-area' ); ?></td>
                            <td class="due" data-order="<?php echo esc_attr( sliced_get_invoice_due( $invoice ) ); ?>"><?php echo sliced_get_invoice_due( $invoice ) ? esc_html( date_i18n( get_option( 'date_format' ), sliced_get_invoice_due( $invoice ) ) ) : __( 'N/A', 'sliced-invoices-client-area' ); ?></td>
                            <td class="title"><?php echo esc_html( get_the_title( $invoice ) ); ?></td>
                            <td class="status"><span class="<?php echo sanitize_title( sliced_get_invoice_status( $invoice ) ); ?>"><?php echo esc_html( sliced_get_client_label( sliced_get_invoice_status( $invoice ), __( sliced_get_invoice_status( $invoice ), 'sliced-invoices' ) ) ); ?></span></td>
                            <td class="number"><?php echo esc_html( sliced_get_prefix( $invoice ) . sliced_get_number( $invoice ) ); ?></td>
                            <td class="totals"><?php echo esc_html( sliced_get_invoice_total( $invoice ) ); ?></td>
                            <td class="actions text-right">
                                <a href="<?php esc_url( the_permalink( $invoice ) ); ?>" class="btn btn-default btn-sm"><?php echo sliced_get_client_label( 'client-viewinvoice-label', 'View Invoice' ); ?></a>
                            </td>
                        </tr>

                    <?php $count++; } ?>

                    </tbody>

                </table>
                </div>
			<!-- SEARCH HIDDEN ////////// -->
            <!--    <script type="text/javascript" charset="utf-8">
                    jQuery(document).ready(function() {

                        var title = '<?php printf( esc_html__( '%s', 'sliced-invoices-client-area' ), $inv_label_plural ) ?><?php echo sanitize_file_name( date_i18n( get_option( 'date_format' ), time() ) ) ?>';
                        
                        jQuery('#table-invoices').DataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "pageLength": 10,
                            buttons: [
                                { extend: 'copy', text: '<i class="fa fa-copy"></i> <?php echo sliced_get_client_label( 'client-copy-label', 'Copy' ); ?>', title: title, exportOptions: { columns: [1,2,3,4,5,6] }  },
                                { extend: 'csv', text: '<i class="fa fa-file-excel-o"></i> CSV', title: title, exportOptions: { columns: [1,2,3,4,5,6] }  },
                                { extend: 'pdf', text: '<i class="fa fa-file-pdf-o"></i> PDF', title: title, exportOptions: { columns: [1,2,3,4,5,6] } },
                            ],
                            "dom": "<'row'<'col-sm-12 search'f>>t<'row'<'col-sm-8' B><'col-sm-4'lp>><'clear'>",
							"oLanguage": {
								"sSearch": "<?php echo sliced_get_client_label( 'client-search-label', 'Search' ); ?>",
								"oPaginate": {
									"sPrevious": "<?php echo sliced_get_client_label( 'client-previous-label', 'Previous' ); ?>",
									"sNext": "<?php echo sliced_get_client_label( 'client-next-label', 'Next' ); ?>"
								}
							},
                        });

                    } );
                </script> -->
            
            <?php else : ?>

                <p class="none"><?php echo sliced_get_client_label( 'client-currentlynoinvoices-label', 'Currently no Invoices' ); ?></p> 

            <?php endif; ?>

            </div>
			
			<hr/>
<!-- FILES ////////////// -->
        <div class="row sliced-quote-items sliced-items">
            
            <div class="col-sm-12">

            <h3><i class="fa fa-sticky-note"></i> Files</h3>           
<!-- FILES TABLE ////////////// -->  
<div class="upf_filelist">
	<?php
	$args = array(
		'post_type' => 'userfile',
		'meta_key' => 'upf_user', 
		'meta_value' => $current_user->user_login,
		'orderby' => 'date',
		'order' => DESC
	);

	if (!empty($_POST['upf_year'])) $args['year'] = $_POST['upf_year'];
	if (!empty($_POST['upf_cat'])) $args['file_categories'] = $_POST['upf_cat'];
	
	$the_query = new WP_Query( $args );


	$html = '';

	$current_year = '';

	// The Loop
	if ($the_query->have_posts()) : 
		while ( $the_query->have_posts() ) : $the_query->the_post(); 
			$year = get_the_date('Y');
			if ($year != $current_year) {
				// echo '<h2>'.$year.'</h2>';
				$current_year = $year;
			}
			?>
	<!--		<div class="report-wrap clearfix">
				<span class="report-name"><a href="<?php the_permalink();?>"><?php the_title();?></a></span>
				<div class="right">
					<a href="?upf=vw&id=<?php echo get_the_ID();?>" class="view-print" target="_blank"><?php _e('View and Print', 'user-private-files');?></a> |
					<a href="?upf=dl&id=<?php echo get_the_ID();?>" class="download" target="_blank"><?php _e('Download', 'user-private-files');?></a>
				</div>
			</div>
	-->
			<?php
		endwhile; 
	endif;
	?>
	</div> 
<div class="table-responsive">
    <table id="table-invoices" class="table table-sm table-bordered table-striped display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="id hidden">ID</th>
                <th class="date"><strong>Uploaded Date</strong></th>
                <th class="title"><strong>File Name</strong></th>
                <th class="actions" data-orderable="false"></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th class="id hidden">ID</th>
                <th class="date"><strong>Uploaded Date</strong></th>
                <th class="title"><strong>File Name</strong></th>
                <th class="actions" data-orderable="false"></th>
            </tr>
        </tfoot>
        <tbody>
            <?php
				$count = 0;
                foreach ( $invoices as $invoice ) {
                $class = ($count % 2 == 0) ? 'even' : 'odd'; ?>
                    <tr class="row_<?php echo $class; ?> sliced-item">
                        <td class="id hidden"><?php echo esc_html( $invoice ); ?></td>
                        <td class="date" data-order="<?php echo esc_attr( sliced_get_created( $invoice ) ); ?>"><?php echo sliced_get_created( $invoice ) ? esc_html( date_i18n( get_option( 'date_format' ), sliced_get_created( $invoice ) ) ) :  __( 'N/A', 'sliced-invoices-client-area' ); ?></td>
                        <td class="title"><span class="report-name"><a href="<?php the_permalink();?>"><?php the_title();?></a></span></td> 
                        <td class="actions text-right">
                            <a href="?upf=vw&id=<?php echo get_the_ID();?>" class="view-print" target="_blank"><?php _e('View and Print', 'user-private-files');?></a>
                        </td>
                        </tr>

                    <?php $count++; } ?>

                    </tbody>

                </table>
            </div>

        </div>

        <hr>
        </div>
		
		<?php endif; ?>

    </div>
