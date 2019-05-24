

<!DOCTYPE html>
<html lang="en">
<head>

    
    
    
    
    

    
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    

    
    <title>Quilder</title>

    
    
        <link rel="shortcut icon" href="/static/img/favicon.ico">
        <!-- List Apple icons largest->smallest -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144"
              href="/static/img/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114"
              href="/static/img/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72"
              href="/static/img/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="57x57"
              href="/static/img/apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/static/img/apple-touch-icon-precomposed.png">
        <link rel="apple-touch-icon" href="/static/img/apple-touch-icon.png">
    

    
    
    
    
        
         <script src="https://www.gstatic.com/firebasejs/3.3.2/firebase.js"></script>
        <script>
            // Initialize Firebase
            var config = {
                apiKey: "AIzaSyCKv8CiVdP2kwKRrl8Apo7ElDt2AW1ULsE",
                authDomain: "friendlychat-7606a.firebaseapp.com",
                databaseURL: "https://friendlychat-7606a.firebaseio.com",
                storageBucket: "friendlychat-7606a.appspot.com",
                };
            firebase.initializeApp(config);
        </script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
        <script src="/static/js/jquery-1.11.1.min.js"></script>
        <script src="/static/js/jquery.cookie.js"></script>
        <script src="/static/js/mustache.js"></script><!-- ONLY NEEDED ON SOME PAGES-->
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    



    <script>
        
        var IS_ORDER = false;
        var CONTACT_SEARCH_URL = "/organisation/8393/clients/list?contacttype=CLI";

        var PARTS_SEARCH_URL = "/organisation/8393/parts/list";
        var GLOBAL_PARTS_SEARCH_URL = "/organisation/8393/parts/supplier/search";
        var LABOUR_SEARCH_URL = "/organisation/8393/parts/labour/list";
        var CURRENCY_SYMBOL = "ZAR";
        var DECIMAL_SYMBOL = ".";
        var CURRENCY_CODE = "ZAR";
        var LANGUAGE_CODE = "en";
        var SALES_TAX_NAME = "VAT";
        var SHOW_TAX_ON_QUOTES_INVOICES = "True";
        
        
        var TAX_RATE = "15.00";
        var LABOUR_TAX_RATE = "15.00";
        var JOB_PARTS_SCHEMA_VERSION = "3";

        function formatNumber(theNumber) {
            try {
                if(navigator.userAgent.indexOf('Safari') > -1){
                    return safariFormat(theNumber);
                }
                else{
                    return ( (Number(theNumber)).toLocaleString(LANGUAGE_CODE, {
                        style: "decimal",
                        minimumFractionDigits: 2
                    }));
                }
            }
            catch (ex) {
                console.log("formatNumber failed");
                console.log(ex);
                return theNumber;
            }
        }
        
        function safariFormat(theNumber){
            return Number(theNumber).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }

    </script>

    <script type="text/javascript" src="/static/js/json2html.js"></script>
    <script type="text/javascript" src="/static/js/jquery.json2html.js"></script>

    
    <script src="/static/js/quilder_calculations.js"></script>
    <script src="/static/js/quilder_calculations.1503666985.js"></script>

    <script src="/static/js/quilder_job_form.js"></script>
    <script src="/static/js/quilder_job_form.1503666985.js"></script>

    <script src="/static/js/quilder_form_contact.js"></script>
    <script src="/static/js/quilder_form_contact.1503666985.js"></script>

    <script src="/static/js/quilder_job_form_parts_and_labour.js"></script>
    <script src="/static/js/quilder_job_form_parts_and_labour.1503666985.js"></script>

    
    

<script id="jobPartTableTpl" type="text/template">
    <table class="table table-bordered table-striped table-hover" width="100%">

        <thead>
        <th>Name</th>
        <th style="text-align:right">Quantity</th>

        
            
            <th>Net Amount</th>
            <th style="text-align:right">Net Total</th>
        

        <th style="text-align:right">Actions</th>
        </thead>
        <tbody>

        
        
        
        [[#top_level_parts]]

        <tr>
            
            <td><h4 class="part-head pull-left">[[& name ]]</h4></td>
            
            <td style="text-align:right"><span>[[ web_formatted_quantity ]]</span></td>
            
            <td>
                <p class="list-group-item-text form-group">
                    
                        
                        [[#web_is_labour]]
                            <span>[[currency_symbol]][[ web_formatted_sales_price_net ]]</span>
                        [[/web_is_labour]]
                        [[^web_is_labour]]
                            <span>[[currency_symbol]][[ web_formatted_sales_price_net ]] each</span>
                        [[/web_is_labour]]
                    
                </p>
            </td>
            
            
                
                
                <td style="text-align:right"><p class="list-group-item-text form-group">[[currency_symbol]][[ web_formatted_part_subtotal_net]] </p></td>
            
            
            <td>
                <div class="pull-right">
                    <a onclick='removeJobPartFromTable([[ web_part_index ]], undefined)' data-toggle="tooltip"
                       data-placement="top" class="btn btn-danger btn-xs" title="Remove"><span
                            class="hidden-xs">Delete</span> <span class="glyphicon glyphicon-remove"></span></a>
                    [[#web_is_labour]]
                    <a href="#"
                       class="btn btn-warning btn-xs"
                       title="Edit" data-toggle="modal"
                       data-target="#searchAndAddLabour"
                       data-placement="top"
                       onclick="editJobPartFromTable([[ web_part_index ]], undefined)"><span
                            class="hidden-xs">Edit</span> <span
                            class="glyphicon glyphicon-plus"></span></a>
                    [[/web_is_labour]]
                    [[^web_is_labour]]
                    <a href="#"
                       class="btn btn-warning btn-xs"
                       title="Edit" data-toggle="modal"
                       data-target="#searchAndAddParts"
                       data-placement="top"
                       onclick="editJobPartFromTable([[ web_part_index ]], undefined)"><span
                            class="hidden-xs">Edit</span> <span
                            class="glyphicon glyphicon-plus"></span></a>
                    [[/web_is_labour]]
                </div>
            </td>
        </tr>
        [[/top_level_parts]]

        [[#sections]]
        <tr>
            
            <td colspan="4" style="font-size:x-large; font-weight: bold" valign="top">[[section_name]]
            </td>

            <td>
                <div class="pull-right">
                    <a onclick='removeSectionFromTable([[web_section_index]], false)' data-toggle="tooltip"
                       data-placement="top" class="btn btn-danger btn-xs" title="Remove"><span
                            class="hidden-xs">Delete</span> <span class="glyphicon glyphicon-remove"></span></a>

                    <a href="#"
                       class="btn btn-warning btn-xs"
                       title="Edit" data-toggle="modal"
                       data-target="#sectionEditModal"
                       data-placement="top"
                       onclick="editSectionFromTable([[web_section_index]])"><span
                            class="hidden-xs">Edit</span> <span
                            class="glyphicon glyphicon-plus"></span></a>

                </div>
            </td>
        </tr>
        
        [[#section_parts]]
        <tr>
            
            <td><h4 class="part-head pull-left">[[& name ]]</h4></td>
            
            <td style="text-align:right"><span>[[ quantity ]]</span></td>
            
            <td>
                <p class="list-group-item-text form-group">
                    
                        
                        [[#web_is_labour]]
                            <span>[[currency_symbol]] [[ web_formatted_sales_price_net ]]</span>
                        [[/web_is_labour]]
                        [[^web_is_labour]]
                            <span> [[currency_symbol]][[ web_formatted_sales_price_net]] each</span>
                        [[/web_is_labour]]
                    
                </p>
            </td>
            
            
                
                
                <td style="text-align:right"><p class="list-group-item-text form-group">[[currency_symbol]][[ web_formatted_part_subtotal_net]] </p></td>
            
            
            <td>
                <div class="pull-right">
                    <a onclick='removeJobPartFromTable([[ web_part_index ]], [[web_section_index]])' data-toggle="tooltip"
                       data-placement="top" class="btn btn-danger btn-xs" title="Remove"><span
                            class="hidden-xs">Delete</span> <span class="glyphicon glyphicon-remove"></span></a>
                    [[#web_is_labour]]
                    <a href="#"
                       class="btn btn-warning btn-xs"
                       title="Edit" data-toggle="modal"
                       data-target="#searchAndAddLabour"
                       data-placement="top"
                       onclick="editJobPartFromTable([[ web_part_index ]], [[web_section_index]])"><span
                            class="hidden-xs">Edit</span> <span
                            class="glyphicon glyphicon-plus"></span></a>
                    [[/web_is_labour]]
                    [[^web_is_labour]]
                    <a href="#"
                       class="btn btn-warning btn-xs"
                       title="Edit" data-toggle="modal"
                       data-target="#searchAndAddParts"
                       data-placement="top"
                       onclick="editJobPartFromTable([[ web_part_index ]], [[web_section_index]])"><span
                            class="hidden-xs">Edit</span> <span
                            class="glyphicon glyphicon-plus"></span></a>
                    [[/web_is_labour]]
                </div>
            </td>
        </tr>
        [[/section_parts]]
        [[/sections]]

        </tbody>
    </table>
    </div>


</script>





    
    
<script id="partEditTpl" type="text/template">
    <!-- Mustache template to edit job parts -->
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-4 control-label">Name: </label>

            <div class="col-sm-8">
                <input type="text" class="form-control" id="job_part_name_edit" value="[[& name ]]">
            </div>
            <div id="job_part_name_edit_error"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Quantity: </label>

            <div class="col-sm-8">
                <input type="number" class="form-control" id="job_part_quantity_edit" value="[[ quantity ]]">
            </div>
            <div id="job_part_quantity_edit_error" ></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Unit Sale price ([[ currency_symbol ]]): </label>

            <div class="col-sm-8">
                <input type="number" class="form-control" id="job_part_sales_price_net_edit"
                       value="[[ sales_price_net ]]">
            </div>
            <div id="job_part_sales_price_net_edit_error"></div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Net Sale price ([[ currency_symbol ]]): </label>

            <div class="col-sm-8">
                <p class="form-control-static"><span id="job_part_total_sales_price_net_edit">[[ part_subtotal_net ]]</span>
                </p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">VAT Rate (%): </label>

            <div class="col-sm-8">
                <p class="form-control-static"><span id="job_part_tax_rate_edit">[[ tax_rate ]]</span></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">VAT Amount ([[ currency_symbol
                ]]): </label>

            <div class="col-sm-8">
                <p class="form-control-static"><span id="job_part_total_tax_edit">[[ part_total_tax ]]</span></p>
            </div>
        </div>
        <hr/>
        <div class="form-group large">
            <label class="col-sm-4 control-label">Total ([[ currency_symbol ]]): </label>

            <div class="col-sm-8">
                <strong><p class="form-control-static"><span id="job_part_total_edit">[[ total ]]</span></p>
                </strong>
            </div>
        </div>
    </div>

</script>

    
    
<script id="labourEditTpl" type="text/template">
    <!-- Mustache template to edit labour parts -->
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-4 control-label">Name: </label>

            <div class="col-sm-8">
                <input type="text" class="form-control" id="labour_part_name_edit" value="[[& name ]]">
            </div>
            <div id="labour_part_name_edit_error"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Labour quantity: </label>

            <div class="col-sm-8">
                <input type="number" class="form-control" id="labour_part_quantity_edit" value="[[ quantity ]]">
            </div>
            <div id="labour_part_quantity_edit_error"></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Labour rate ([[ currency_symbol ]]): </label>

            <div class="col-sm-8">
                <input type="number" class="form-control" id="labour_part_sales_price_net_edit"
                       value="[[ sales_price_net ]]">
            </div>
            <div id="labour_part_sales_price_net_edit_error"></div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">Net labour price ([[ currency_symbol ]]): </label>

            <div class="col-sm-8">
                <p class="form-control-static"><span id="labour_part_total_sales_price_net_edit">[[ part_subtotal_net ]]</span>
                </p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">VAT Rate (%): </label>

            <div class="col-sm-8">
                <p class="form-control-static"><span id="labour_part_tax_rate_edit">[[ tax_rate ]]</span></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">VAT amount ([[ currency_symbol
                ]]): </label>

            <div class="col-sm-8">
                <p class="form-control-static"><span id="labour_part_total_tax_edit">[[ part_total_tax ]]</span></p>
            </div>
        </div>
        <hr/>
        <div class="form-group large">
            <label class="col-sm-4 control-label">Total ([[ currency_symbol ]]): </label>

            <div class="col-sm-8">
                <strong><p class="form-control-static"><span id="labour_part_total_edit">[[ total ]]</span></p>
                </strong>
            </div>
        </div>
    </div>

</script>

    
    
<script id="sectionDropdownTpl" type="text/template">
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-4 control-label">Section: </label>

            <div class="col-sm-8">
                <select id="sectionsDropdown" class="form-control">
                    <option value="-1">No section</option>
                    [[#.]]
                    <option value="[[web_section_index]]">[[section_name]]</option>
                    [[/.]]
                </select>
            </div>
        </div>
    </div>
</script>



    
    
        
         <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700'
              rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic'
              rel='stylesheet' type='text/css'>

        <link href="/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/static/css/animation.css" rel="stylesheet"><!-- CSS animation library stylesheet-->
        <link href="/static/css/jquery.fileupload.css" rel="stylesheet"><!-- Jquery File Upload-->
        <!-- ONLY NEEDED ON ORG REG PAGE-->
        <link href="/static/css/slider.css" rel="stylesheet"><!-- Range Slider Control -->
        <!-- ONLY NEEDED ON SEARCH FILTERS WITH RANGE SLIDERS PAGES -->
        <link href="/static/bootstrap/css/ionicons.min.css" rel="stylesheet"><!-- Icon Library -->
        <link href="/static/css/bootstrap-switch.min.css" rel="stylesheet"><!-- BS Switch -->
        <link href="/static/css/style.min.css" type="text/css" rel="stylesheet">
        <link href="/static/css/style.min.1503666971.css" type="text/css" rel="stylesheet"><!-- main stylesheet-->
    
</head>



  <!--base.html template-->
    <body class="quote">




    
        



<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container-fluid">
        
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target=".nav-main">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="/"><img alt="Quilder" title="Click here to go to the homepage"
                                                  src="/static/img/quilder-logo-w.png"/></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse nav-main collapse">
            <ul class="nav navbar-nav navbar-left navbar-tasks">

                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="ion ion-clipboard"></span> Quotes  <b
                            class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/jobs/quotes/add"><span class="glyphicon glyphicon-plus"></span> Create Quote</a></li>
                        <li><a href="/jobs/quotes/list"><span class="glyphicon glyphicon-search"></span> View All Quotes</a></li>
                        <li class="divider"></li>
                        <li><a href="/organisation/quotes/templates/edit"><span class="glyphicon glyphicon-list-alt"></span> Quote Template</a></li>
                        <li><a href="/organisation/templates/quotes/emails/edit"><span class="glyphicon glyphicon-envelope"></span>  Quote Email Template</a></li>
                        <li><a href="/organisation/templates/quotes/sms/edit"><span class="glyphicon glyphicon-phone"></span> Quote Sms Template</a></li>
                    </ul>
                </li>

                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="ion ion-document"></span> Estimates  <b
                            class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/jobs/estimates/add"><span class="glyphicon glyphicon-plus"></span> Create Estimate</a></li>
                        <li><a href="/jobs/estimates/list"><span class="glyphicon glyphicon-search"></span> View All Estimates</a></li>
                        <li class="divider"></li>
                        <li><a href="/organisation/estimates/templates/edit"><span class="glyphicon glyphicon-list-alt"></span> Estimate Template</a></li>
                        <li><a href="/organisation/templates/estimates/emails/edit"><span class="glyphicon glyphicon-envelope"></span> Estimate Email Template</a></li>
                        <li><a href="/organisation/templates/estimates/sms/edit"><span class="glyphicon glyphicon-phone"></span> Estimate Sms Template</a></li>

                    </ul>
                </li>

                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="ion ion-document-text"></span> Invoices <b
                            class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/jobs/invoices/add"><span class="glyphicon glyphicon-plus"></span> Create Invoice </a></li>
                        <li><a href="/jobs/invoices/list"><span class="glyphicon glyphicon-search"></span> View All Invoices</a></li>
                        <li class="divider"></li>
                        <li><a href="/organisation/invoices/templates/edit"><span class="glyphicon glyphicon-list-alt"></span> Invoice Template</a></li>
                        <li><a href="/organisation/templates/invoices/emails/edit"><span class="glyphicon glyphicon-envelope"></span> Invoice Email Template</a></li>
                        <li><a href="/organisation/templates/invoices/sms/edit"><span class="glyphicon glyphicon-phone"></span> Invoice Sms Template</a></li>
                    </ul>
                </li>

                
                
                <li class="dropdown">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="ion ion-ios7-cart"></span> Shopping Lists  <b
                            class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/orders/add/"><span class="glyphicon glyphicon-plus"></span>  Create Shopping List </a></li>
                        <li><a href="/orders/list"><span class="glyphicon glyphicon-search"></span>  View All Shopping Lists</a></li>
                        </ul>
                </li>
                
                
                <li class="dropdown">
                    <a href="#"  data-toggle="dropdown"><span class="ion ion-person-stalker"></span> Contacts <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/clients/add"><span class="glyphicon glyphicon-plus"></span> Add Client</a></li>
                        
                            <li><a href="/clients/supplieradd"><span class="glyphicon glyphicon-plus"></span> Add Supplier</a></li>
                        
                        <li><a href="/clients/list"><span class="glyphicon glyphicon-search"></span> View All Contacts</a></li>
                    </ul>
                </li>

                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                            class="ion ion-settings"></span> Parts <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/parts/add"><span class="glyphicon glyphicon-plus"></span> Add Company Part</a>
                        </li>
                        <li><a href="/parts/list"><span class="glyphicon glyphicon-search"></span> View Company Parts</a></li>
                         <li class="divider"></li>
                        <li><a href="/parts/supplier/search"><span class="glyphicon glyphicon-globe"></span> Search Supplier Parts</a></li>
                    </ul>
                </li>

                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                            class="ion ion-settings"></span> Labour <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/parts/labour/add"><span class="glyphicon glyphicon-plus"></span> Add Labour Prices</a>
                        </li>
                        <li><a href="/parts/labour/list"><span class="glyphicon glyphicon-search"></span> View Labour Prices</a></li>


                    </ul>
                </li>

                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                            class="ion ion-gear-b"></span> Settings <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/organisation/users/add/"><span class="glyphicon glyphicon-plus"></span> Add User</a></li>
                        <li><a href="/organisation/users/"><span class="glyphicon glyphicon-search"></span> View All Users</a></li>
                        <li><a href="/organisation/view/"><span
                                class="glyphicon glyphicon-info-sign"></span>  Edit Company Details</a></li>
                        <li><a href="/organisation/settings/tax/edit"><span
                                class="glyphicon glyphicon-info-sign"></span>  Company Tax Settings</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right navbar-user">
                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown"><strong class="hidden-md hidden-sm">example@domain.com </strong><span
                            class="glyphicon glyphicon-user" data-toggle="tooltip" data-placement="bottom"
                            title="Netbrowse"></span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/accounts/password/change/"><span
                                class="glyphicon glyphicon-lock"></span>  Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="/accounts/logout/"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

</nav>




    




    <div id="wrap" class="container gap">
        <div class="wrapper">

            <!-- MAIN CONTENT -->
            

    
    <div class="pull-right small">
        
    </div>

    
    
    <h3 class="page-header">Create your
        
            quote
         below</h3>


    <div class="page-style">
    <form action="" method="POST" id="form">
    <input type='hidden' name='csrfmiddlewaretoken' value='2At4RQsVbQkWB9bgTVVedlL7Xx7LNHNa' />

    
    

    
    <input id="id_sales_tax_name" name="sales_tax_name" type="hidden" value="VAT" />
    <input id="id_currency_code" name="currency_code" type="hidden" value="ZAR" />
    <input id="id_show_tax_on_quotes_invoices" name="show_tax_on_quotes_invoices" type="hidden" value="True" />

    
    

    
    <div class="row">
        <div class="col-sm-6">
            <address class="form-group">
                <label class="control-label"> Company Address: </label>
                
                    <p class="form-control-static"><span  id="id_organization_address_heading" name="organization_address_heading">Shop No 2, 24B Devereaux Avenue</span></p>
                
                
                    <p class="form-control-static">
                        <span  id="id_organization_address_business" name="organization_address_business">Company Name</span></p>
                
                
                    <p class="form-control-static">
                        <span  id="id_organization_address_street" name="organization_address_street">Company Address</span></p>
                
                
                    <p class="form-control-static">
                        <span  id="id_organization_address_town" name="organization_address_town">Reg. Number: 2XXXXX/XX</span></p>
                
                
                    <p class="form-control-static">
                        <span  id="id_organization_address_region" name="organization_address_region">Tax Number: XXXXXXXXXX</span></p>
                
                
                    <p class="form-control-static">
                        <span  id="id_organization_address_postcode" name="organization_address_postcode">VAT Number: XXXXXXXX</span></p>
                
            </address>
            
                <div class="form-inline">
                    <label class="control-label">Tel: </label>
                    <span class="form-control-static">
                        <span  id="id_organization_tel_no" name="organization_tel_no">043XXXXX   Cell: 0XXXXXX</span></span>
                </div>
            

            
                <div class="form-inline">
                    <label class="control-label">Email: </label>

                    <span class="form-control-static"> <span  id="id_organization_email" name="organization_email">email@domain.com</span></span></div>
            
            
        </div>


        <!-- Organization logo -->
        <div class="col-sm-6">
            <div id="org-img">
                
                    <img class="thumbnail pull-right" src="/media/orglogos/logo1_PRbyxru.png" alt=""/>
                

            </div>
            <!-- eo / -->
        </div>
        <!-- eo / col-->

    </div>

    <hr/>

    
    <div class="row">
        <div class="col-sm-6">
            <div class="well editable user-edit">

                
                <a href="#" class="pull-right btn btn-quote" data-toggle="modal" data-target="#searchAndAddContact"
                   data-placement="left"
                   onclick="showContactSearchPanelWithinModal();"><span class="hidden-xs">Find Client</span> <span
                        class="glyphicon glyphicon-search"></span></a>

                <div class="clearfix"></div>

                
                <label class="control-label">
                    
                        Quote
                     for: </label>

                <div id="contactFields">
                    
                    <div class="form-inline">

                        
                        <input class="col-sm-6 inline form-control" id="id_client_first_name" maxlength="255" name="client_first_name" placeholder="Client first name" type="text" />

                        
                        <input class="col-sm-6 inline form-control" id="id_client_last_name" maxlength="255" name="client_last_name" placeholder="Client last name" type="text" />
                    </div>
                    <fieldset>
                        <legend>Address details</legend>

                        <div class="form-group">
                            
                            <input class="form-control" id="id_client_address_business" maxlength="255" name="client_address_business" placeholder="Client business" type="text" />
                        </div>
                        <div class="form-group">
                            
                            <textarea class="form-control" cols="40" id="id_client_unformatted_address" name="client_unformatted_address" placeholder="Address" rows="10">
</textarea>
                        </div>
                        <div class="form-group">
                            
                            <input class="form-control" id="id_client_address_street" maxlength="255" name="client_address_street" placeholder="Street" type="text" />
                        </div>
                        <div class="form-group">
                            
                            <input class="form-control" id="id_client_address_town" maxlength="255" name="client_address_town" placeholder="Town" type="text" />
                        </div>
                        <div class="form-group">
                            
                            <input class="form-control" id="id_client_address_region" maxlength="255" name="client_address_region" placeholder="Region" type="text" />
                        </div>
                        <div class="form-group">
                            
                            <input class="form-control" id="id_client_address_postcode" maxlength="255" name="client_address_postcode" placeholder="Postcode" type="text" />
                        </div>
                    </fieldset>
                    <div class="form-group">
                        
                        <input class="form-control" id="id_client_email" maxlength="255" name="client_email" placeholder="Email" type="text" />
                    </div>


                </div>
                
                <input id="id_client_id" name="client_id" type="hidden" /> 
                <input id="id_original_contact" name="original_contact" type="hidden" />
                <input id="id_force_new_contact" name="force_new_contact" type="hidden" />
                
                <input id="id_client_work_telephone" name="client_work_telephone" type="hidden" />
                <input id="id_client_cell_telephone" name="client_cell_telephone" type="hidden" />
                <input id="id_client_home_telephone" name="client_home_telephone" type="hidden" />

                <input type="hidden" name="save_contact" id="save_contact" value="0">
            </div>
            <!-- /well -->
        </div>
        <!-- /col6 -->

        
        <div class="col-sm-6" id="ref-nums">
            <div class="well user-edit" style="min-height: 412px;">
                <div class="form-horizontal">

                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="id_job_name">Quote name:</label>
                        <div class="col-sm-7"><input class="col-sm-5 form-control" id="id_job_name" maxlength="255" name="job_name" type="text" />
                            </div>
                    </div>

                    
                    <div class="form-group">
                        
                        
                        <input id="id_job_date" name="job_date" type="hidden" value="2018-09-28" />
                        <label class="col-sm-5 control-label" for="id_job_name">
                            
                                Quote
                            
                            date:</label>

                        <div class="col-sm-7" data-original-title="" title="">
                            <input class="form-control" id="id_job_date_dummy"
                                   name="id_job_date_dummy" readonly="readonly" type="text" value="Sept. 28, 2018">
                        </div>

                    </div>

                    
                    <div class="form-group">
                        <label class="col-sm-5 control-label" for="id_job_reference">Quote reference:</label>
                        <div class="col-sm-7"><input class="form-control" id="id_job_reference" maxlength="255" name="job_reference" readonly="readonly" type="text" value="JUD-1538121021" />
                            </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <!-- /right -->
            </div>
            <!-- /ell -->
        </div>
        <!-- /col6 -->
    </div>
    <!-- /row -->
    <hr>

    
    <div class="user-edit">
        <h3>Description Of Work</h3>
        <div class="form-group"><textarea class="form-control" cols="40" id="id_scope_of_work" name="scope_of_work" placeholder="Fill in details of the job" rows="10">
</textarea></div>
    </div>

    <hr>

    
    <div class="user-edit">
        
        <h3>Quote Details
            <div class="pull-right">
                
                <a href="#" class="btn btn-quote" title="Add a section to the job" data-toggle="modal"
                   data-target="#sectionAddModal" data-placement="left"
                   onclick="showSectionAddModal();populateSectionAddModal();"><span class="hidden-xs">Add Section</span> <span
                        class="glyphicon glyphicon-plus"></span></a>

                <!-- Add labour button -->
                <a href="#" class="btn btn-quote" title="Add labour to the job" data-toggle="modal"
                   data-target="#labourSearchAndAddModal" data-placement="left"
                   onclick="showLabourSearchModal()"><span class="hidden-xs">Add Labour</span> <span
                        class="glyphicon glyphicon-plus"></span></a>

                <!-- Add job part button -->
                <a href="#" class="btn btn-quote" title="Add a part to the job" data-toggle="modal"
                   data-target="#partsSearchAndAddModal" data-placement="left"
                   onclick="showSupplierPartsSearchModal()"><span class="hidden-xs">Add Parts</span> <span
                        class="glyphicon glyphicon-plus"></span></a>
            </div>
        </h3>

        
        <input id="id_parts" name="parts" type="hidden" />
        <br />
        
        <div id="jobPartsTableDiv">

        </div>
    </div>

    <hr>

    <div class="row">
        
        <div class="col-sm-6">
            <div class="user-edit">
                
                <div class="form-group"><h3 class="payment-terms"><input class="form-control large-text" id="id_terms_heading" maxlength="255" name="terms_heading" type="text" value="Bank Details" /></h3></div>
                <div class="form-group">
                    <textarea class="form-control" cols="40" id="id_terms" name="terms" placeholder="The details of your terms and conditions can be written here" rows="10">
FNB Cheque Account
: 62589280066</textarea></div>
            </div>
        </div>
        <!-- /col6 -->

        
        <div class="col-sm-6 align-right">
            <table id="table-invoice-total" class="form-inline table table-striped">
                <tbody>

                
                    
                    <tr>
                        <th class="vertical-th">Total Net Amount</th>
                        
                        <td><label class="control-label">ZAR</label> <input class="form-control" id="id_total_net" name="total_net" readonly="readonly" type="text" />
                        </td>
                    </tr>
                    
                    <tr>
                        
                        <th class="vertical-th">Total VAT Amount</th>
                        <td><label class="control-label"> ZAR </label> <input class="form-control" id="id_total_tax" name="total_tax" readonly="readonly" type="text" />
                        </td>
                    </tr>
                

                
                <tr>
                    <th class="vertical-th">
                        Quote Total
                    </th>
                    
                    <td><label class="control-label"> ZAR </label> <input class="form-control" id="id_job_total" name="job_total" readonly="readonly" type="text" />
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /col6 -->
    </div>
    <!--/row -->

    <!-- Save -->
    <hr/>

    <div class="row">

        
            <div class="col-md-6">
                <a href="/" class="btn btn-default btn-block btn-lg" id="cancel_draft"
                   name="cancel_draft"
                   title="Cancel">Cancel <span class="glyphicon glyphicon-remove-circle"></span></a>
            </div>
            <div class="col-md-6">
                <button type="submit"  class="btn btn-quote btn-block btn-lg" id="save_draft" name="save_draft"
                        title="Save">Save <span
                        class="glyphicon glyphicon-floppy-disk"></span></button>
            </div>
        
    </div>


    </form>
    <!-- /row -->
    </div>

    
    

<div class="modal fade" id="labourSearchAndAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        
        <ul id="myTab" class="nav nav-tabs">
            <li id="labourSearchAndAddModalSearchTab"><a href="#profile" onClick="showLabourSearchModal()"
                                                         data-toggle="tab">Search Saved Labour</a></li>
            <li id="labourSearchAndAddModalAddTab"><a href="#addPart" data-toggle="tab"
                                                      onClick="showLabourAddModal(); populateLabourAddModal();">Add
                Labour</a></li>
        </ul>

        
        <div class="modal-content tab-content" id="labourSearchAndAddModalSearchPanel">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Search Saved Labour</h4>
            </div>

            
            <div class="modal-body">
                <form class="" role="search" action="" method="GET" id="labour-search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search labour" id="txtSearchSavedLabour"
                               name="search_term"
                               style="width:100%;padding:6px 6px;" accept=""
                                
                                >

                        <div class="input-group-btn">
                            <button id="btnSearchSavedLabour" class="btn btn-default" type="submit"><span
                                    class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div>

                    <br/>

                </form>
                <div id="labourSearchResultsDiv">
                    <!-- part search results go here -->
                </div>
            </div>

            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

        
        <div class="modal-content tab-content" id="labourSearchAndAddModalAddPanel" hidden="true">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add New Labour</h4>
            </div>

            
            <div class="modal-body">
                <div id="labourAddSectionDropdownDiv" aria-hidden="false"></div>
                <div id="labourAddDiv"></div>
                
                <input type="hidden" id="labourEditJSON"/>
            </div>

            
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success btn-block"
                                onclick="updateJobPartTableFromLabourAddModal(true)">Add
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

    
    

<div class="modal fade" id="labourEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="false">
    <div class="modal-dialog">
        
        <div class="modal-content" id="labourEditPanel" hidden="false">

            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Labour</h4>
            </div>

            
            <div class="modal-body">
                <div id="labourEditSectionDropdownDiv" aria-hidden="false"></div>
                <div id="labourEditDiv"></div>
                
                <input type="hidden" id="labourEditJSON"/>
            </div>

            
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success btn-block"
                                onclick="updateJobPartTableFromLabourEditModal(true)">Update
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    
    
<div class="modal fade" id="partsSearchAndAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        
        <ul id="myTab" class="nav nav-tabs">
            <li id="tabSupplierParts" class="active"><a href="#global" data-toggle="tab"
                                                      onClick="showSupplierPartsSearchModal()">Supplier
                Parts</a></li>
            <li id="tabSavedParts"><a href="#profile" onClick="showSavedPartsSearchModal()"
                                      data-toggle="tab">Company Parts</a></li>
            <li id="tabAddParts"><a href="#addPart" data-toggle="tab"
                                    onClick="showPartsAddModal(); populatePartsAddModal()">Add Parts</a></li>

        </ul>

        
        <div class="modal-content tab-content" id="partsSearchAndAddModalSupplierPartsPanel">

            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Search Supplier Parts</h4>
            </div>
            
            <div class="modal-body">
                <form class="" role="search" action="" method="GET" id="search-global-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search supplier parts" id="txtSearchSupplierParts"
                               name="searchquery"
                               style="width:100%;padding:6px 6px;" accept=""
                                
                                >

                        <div class="input-group-btn">
                            <button id="btnSearchSupplierParts" class="btn btn-default" type="submit"><span
                                    class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div>

                    <br/>

                </form>
                <div id="partGlobalSearchResultsDiv">
                    <!-- part search results go here -->
                </div>

                <!-- Error when no keyword -->
                <div id="globalPartsSearchError" class="alert alert-danger fade in">
                    <strong>Search term required for supplier parts search</strong>
                </div>

            </div>

            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

        
        <div class="modal-content tab-content" id="partsSearchAndAddModalSavedPartsPanel">

            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Company Parts</h4>
            </div>

            
            <div class="modal-body">
                <form class="" role="search" action="" method="GET" id="part-search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search parts" id="txtSearchSavedParts"
                               name="search_term"
                               style="width:100%;padding:6px 6px;" accept=""
                                
                                >

                        <div class="input-group-btn">
                            <button id="btnSearchSavedParts" class="btn btn-default" type="submit"><span
                                    class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div>

                    <br/>

                </form>
                <div id="partSearchResultsDiv">
                    <!-- part search results go here -->
                </div>
            </div>

            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

       
        <div class="modal-content tab-content" id="partsSearchAndAddModalAddPartsPanel" hidden="true">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add New Part</h4>
            </div>

            
            <div class="modal-body">
                <div id="partAddSectionDropdownDiv" aria-hidden="false"></div>
                <div id="partAddDiv"></div>
                 <input type="hidden" id="partEditJSON"/>
            </div>

            
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success btn-block"
                                onclick="updateJobPartTableFromPartsAddModal(true)">Add
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    
    


<div class="modal fade" id="partsEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="false">
    <div class="modal-dialog">

        
        <div class="modal-content" id="partsEditPanel" hidden="true">

            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Part</h4>
            </div>

            
            <div class="modal-body">
                <div id="partEditSectionDropdownDiv" aria-hidden="false"></div>
                <div id="partEditDiv"></div>
                
                <input type="hidden" id="partEditJSON"/>
            </div>

            
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success btn-block"
                                onclick="updateJobPartTableFromPartsEditModal(true)">Update
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    
    
<div class="modal fade" id="sectionAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" >

        
        <div class="modal-content" id="sectionAddPanel">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Section</h4>
            </div>

            
            <div class="modal-body">
                <div class="form-horizontal">
                    <div id="labourSectionAddDiv">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Name: </label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="section_name_add" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success btn-block"
                                onclick="updateJobPartTableFromSectionAddModal(true)">Save
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    
    
<div class="modal fade" id="sectionEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">

        
        <div class="modal-content" id="sectionEditPanel" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Section</h4>
            </div>

            
            <div class="modal-body">
                <div class="form-horizontal">
                    <div id="labourSectionAddDiv">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Name: </label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="section_name_edit" value="">
                                
                                <input type="hidden" id="sectionEditJSON"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-success btn-block"
                                onclick="updateJobPartTableFromSectionEditModal(true)">Save
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    
    

<div class="modal fade" id="sectionDeleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">

        
        <div class="modal-content" id="sectionDeleteConfirmModalPanel">

            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Section?</h4>
            </div>

            
            <div class="modal-body">
                Deleting a section will delete all parts within that section. Are you sure?
                
                <input type="hidden" value="" id="sectionDeleteConfirmModalSectionIndex">
            </div>

            
            <div class="modal-footer">
                <div class="col-sm-4">
                    <button type="button" class='btn btn-primary btn-block'
                            onClick="deleteSectionFromSectionDeleteConfirmModal()">Delete Section
                    </button>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                </div>

            </div>

        </div>
    </div>
</div>

    
    
<div class="modal fade" id="searchAndAddContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        
        <div class="modal-content" id="searchContactDiv">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title" id="myModalLabel">
                
                    Find client
                
                </h4>

            </div>

            
            <div class="modal-body">
                <form class="form-horizontal" role="search" action="" method="GET" id="contactSearchForm">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search clients"
                               id="txtSearchContact"
                               name="search_term"
                               style="width:100%;padding:6px 6px;" accept=""
                                
                                >

                        <div class="input-group-btn">
                            <button id="btnSearchContacts" class="btn btn-default" type="submit"><span
                                    class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div>
                    <br/>

                </form>
                <div class="" id="contactSearchResultsDiv">
                    <!-- Contact search results go here -->
                </div>
                <!-- Edit client div. Show/hide -->
                <div class="modal-content" id="editContactDiv" hidden="true">
                    <!-- Note: we don't do any editing of selected clients yet.-->
                </div>
            </div>

            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>

    
    

<div class="modal fade" id="noContactEnteredWarningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        
        <div class="modal-content" id="noContactDetails">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">No Client  Details Entered</h4>
            </div>

            
            <div class="modal-body">
                
                    You have not entered any client details. Are you sure you want to save?
                
            </div> <!-- eo /.modal-body-->

            
            <div class="modal-footer">
                
                <div class="col-md-6 col-xs-6">
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                </div>
                <div class="col-md-6 col-xs-6">
                    <a id="btnSaveNoContactEnteredWarningModal" class='btn btn-primary btn-block' href="#">Save</a>
                </div>
                
            </div>
        </div>

    </div>
</div>

    
    


<div class="modal fade" id="saveContactQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">

        
        <div class="modal-content" id="saveContactDetails">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Save Client?</h4>
            </div>

            
            <div class="modal-body">
                Would you like to save this client's details to your contact list?
            </div>

            
            <div class="modal-footer">
                <div class="col-md-4 col-xs-6">
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                </div>
                <div class="col-md-4 col-xs-6">
                    <a id="dontSaveContactButton" class='btn btn-danger btn-block' href="#">No</a>
                </div>
                <div class="col-md-4 col-xs-6">
                    <a id="saveContactButton" class='btn btn-success btn-block' href="#">Yes</a>
                </div>
            </div>

        </div>

    </div>
</div>

    
    






<div class="modal fade" id="saveExistingContactQuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">

        
        <div class="modal-content" id="saveExistingContactDetails">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Save and Update Client Details</h4>
            </div>

            
            <div class="modal-body" data-original-title="" title="">
                <div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <ul class="messages">
                        <li class="success">This client's details have updated</li>
                    </ul>
                </div>
                
                <h4>Old details</h4>
                <div id="contactPreviousDetails" class="form-group"></div>

                
                <h4>New details</h4>
                <div id="contactNewDetails" class="form-group"></div>
            </div>

            
            <div class="modal-footer">
                <div class="col-md-3 col-xs-6">
                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
                </div>
                <div class="col-md-3 col-xs-6">
                    <a id="saveExistingContactButton" class='btn btn-primary btn-block' href="#">Update</a>
                </div>
                <div class="col-md-3 col-xs-6">
                    <a id="dontSaveExistingContactButton" class='btn btn-primary btn-block' href="#">Do Not Update</a>
                </div>
                <div class="col-md-3 col-xs-6">
                    <a id="saveNewContactButton" class='btn btn-primary btn-block' href="#">Add As New</a>
                </div>
            </div>
        </div>

    </div>
</div>

    
    
<div class="modal fade" id="noPartsWarningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        
        <div class="modal-content" id="noClientDetails">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">No Parts Included</h4>
            </div>

            
            <div class="modal-body">
                You must include  some parts to save the quote.
            </div> <!-- eo /.modal-body-->

            
            <div class="modal-footer">
                <div class="col-md-12 col-xs-12">
                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">OK</button>
                </div>

            </div>
        </div>

    </div>
</div>



        </div>
        <!-- eo/ wrapper-->
    </div>    <!-- eo/ wrap-->









    <div id="footer">
        <div class="container">
            <p class="pull-left text-muted">© Pulsion Technology 2015</p>

            <p class="pull-right text-muted"><a target="_blank"
                                                href="https://itunes.apple.com/gb/app/quilder/id876461811?mt=8">Download
                iOS App <span class="glyphicon glyphicon-download-alt"></span></a>
                | <a target="_blank"
                     href="https://play.google.com/store/apps/details?id=com.quilder.android.app">Download Android App <span
                        class="glyphicon glyphicon-download-alt"></span></a>
                | <a href="/contact/">Send Us Feedback  <span
                        class="glyphicon glyphicon-envelope"></span></a>
                | <a target="_blank" href="http://forum.quilder.com">Support <span
                        class="ion ion-help-buoy"></span></a>
            </p>
        </div>
    </div><!-- eo /footer -->




    
    <!-- Javascript -->
    <script src="/static/bootstrap/js/bootstrap.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed-->
    <script src="/static/js/bootstrap-switch.min.js"></script><!-- BS SWITCH-->
    <!-- Bootstrap range slider plugin-->
    <script src="/static/js/bootstrap-slider.js"></script>
    <!-- ONLY NEEDED ON SEARCH FILTERS WITH RANGE SLIDERS PAGES-->
    <!-- File Upload Styling -->
    <script src="/static/js/bootstrap-filestyle.min.js"></script><!-- ONLY NEEDED ON ORG REG PAGE-->











    <!-- CUSTOM JS -->
    <script src="/static/js/footer.js"></script><!-- for customizing bootstrap js-->
    <script src="/static/js/sidebar-filter.js"></script><!-- only required on list pages with search filters -->




    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-51397286-1', 'quilder.com');
        ga('send', 'pageview');
    </script>

</body>
</html>