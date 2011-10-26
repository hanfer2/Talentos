/*
 * File:        jquery.dataTables.js
 * Version:     1.7.5
 * Description: Paginate, search and sort HTML tables
 * Author:      Allan Jardine (www.sprymedia.co.uk)
 * Created:     28/3/2008
 * Language:    Javascript
 * License:     GPL v2 or BSD 3 point style
 * Project:     Mtaala
 * Contact:     allan.jardine@sprymedia.co.uk
 * 
 * Copyright 2008-2010 Allan Jardine, all rights reserved.
 *
 * This source file is free software, under either the GPL v2 license or a
 * BSD style license, as supplied with this software.
 * 
 * This source file is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 * 
 * For details please refer to: http://www.datatables.net
 */

/*
 * When considering jsLint, we need to allow eval() as it it is used for reading cookies and 
 * building the dynamic multi-column sort functions.
 */
/*jslint evil: true, undef: true, browser: true */
/*globals $, jQuery,_fnExternApiFunc,_fnInitalise,_fnInitComplete,_fnLanguageProcess,_fnAddColumn,_fnColumnOptions,_fnAddData,_fnGatherData,_fnDrawHead,_fnDraw,_fnReDraw,_fnAjaxUpdate,_fnAjaxUpdateDraw,_fnAddOptionsHtml,_fnFeatureHtmlTable,_fnScrollDraw,_fnAjustColumnSizing,_fnFeatureHtmlFilter,_fnFilterComplete,_fnFilterCustom,_fnFilterColumn,_fnFilter,_fnBuildSearchArray,_fnBuildSearchRow,_fnFilterCreateSearch,_fnDataToSearch,_fnSort,_fnSortAttachListener,_fnSortingClasses,_fnFeatureHtmlPaginate,_fnPageChange,_fnFeatureHtmlInfo,_fnUpdateInfo,_fnFeatureHtmlLength,_fnFeatureHtmlProcessing,_fnProcessingDisplay,_fnVisibleToColumnIndex,_fnColumnIndexToVisible,_fnNodeToDataIndex,_fnVisbleColumns,_fnCalculateEnd,_fnConvertToWidth,_fnCalculateColumnWidths,_fnScrollingWidthAdjust,_fnGetWidestNode,_fnGetMaxLenString,_fnStringToCss,_fnArrayCmp,_fnDetectType,_fnSettingsFromNode,_fnGetDataMaster,_fnGetTrNodes,_fnGetTdNodes,_fnEscapeRegex,_fnDeleteIndex,_fnReOrderIndex,_fnColumnOrdering,_fnLog,_fnClearTable,_fnSaveState,_fnLoadState,_fnCreateCookie,_fnReadCookie,_fnGetUniqueThs,_fnScrollBarWidth,_fnApplyToChildren,_fnMap*/

(function($, window, document) {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Section - DataTables variables
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/*
	 * Variable: dataTableSettings
	 * Purpose:  Store the settings for each dataTables instance
	 * Scope:    jQuery.fn
	 */
	$.fn.dataTableSettings = [];
	var _aoSettings = $.fn.dataTableSettings; /* Short reference for fast internal lookup */
	
	/*
	 * Variable: dataTableExt
	 * Purpose:  Container for customisable parts of DataTables
	 * Scope:    jQuery.fn
	 */
	$.fn.dataTableExt = {};
	var _oExt = $.fn.dataTableExt;
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Section - DataTables extensible objects
	 * 
	 * The _oExt object is used to provide an area where user dfined plugins can be 
	 * added to DataTables. The following properties of the object are used:
	 *   oApi - Plug-in API functions
	 *   aTypes - Auto-detection of types
	 *   oSort - Sorting functions used by DataTables (based on the type)
	 *   oPagination - Pagination functions for different input styles
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/*
	 * Variable: sVersion
	 * Purpose:  Version string for plug-ins to check compatibility
	 * Scope:    jQuery.fn.dataTableExt
	 * Notes:    Allowed format is a.b.c.d.e where:
	 *   a:int, b:int, c:int, d:string(dev|beta), e:int. d and e are optional
	 */
	_oExt.sVersion = "1.7.5";
	
	/*
	 * Variable: sErrMode
	 * Purpose:  How should DataTables report an error. Can take the value 'alert' or 'throw'
	 * Scope:    jQuery.fn.dataTableExt
	 */
	_oExt.sErrMode = "alert";
	
	/*
	 * Variable: iApiIndex
	 * Purpose:  Index for what 'this' index API functions should use
	 * Scope:    jQuery.fn.dataTableExt
	 */
	_oExt.iApiIndex = 0;
	
	/*
	 * Variable: oApi
	 * Purpose:  Container for plugin API functions
	 * Scope:    jQuery.fn.dataTableExt
	 */
	_oExt.oApi = { };
	
	/*
	 * Variable: aFiltering
	 * Purpose:  Container for plugin filtering functions
	 * Scope:    jQuery.fn.dataTableExt
	 */
	_oExt.afnFiltering = [ ];
	
	/*
	 * Variable: aoFeatures
	 * Purpose:  Container for plugin function functions
	 * Scope:    jQuery.fn.dataTableExt
	 * Notes:    Array of objects with the following parameters:
	 *   fnInit: Function for initialisation of Feature. Takes oSettings and returns node
	 *   cFeature: Character that will be matched in sDom - case sensitive
	 *   sFeature: Feature name - just for completeness :-)
	 */
	_oExt.aoFeatures = [ ];
	
	/*
	 * Variable: ofnSearch
	 * Purpose:  Container for custom filtering functions
	 * Scope:    jQuery.fn.dataTableExt
	 * Notes:    This is an object (the name should match the type) for custom filtering function,
	 *   which can be used for live DOM checking or formatted text filtering
	 */
	_oExt.ofnSearch = { };
	
	/*
	 * Variable: afnSortData
	 * Purpose:  Container for custom sorting data source functions
	 * Scope:    jQuery.fn.dataTableExt
	 * Notes:    Array (associative) of functions which is run prior to a column of this 
	 *   'SortDataType' being sorted upon.
	 *   Function input parameters:
	 *     object:oSettings-  DataTables settings object
	 *     int:iColumn - Target column number
	 *   Return value: Array of data which exactly matched the full data set size for the column to
	 *     be sorted upon
	 */
	_oExt.afnSortData = [ ];
	
	/*
	 * Variable: oStdClasses
	 * Purpose:  Storage for the various classes that DataTables uses
	 * Scope:    jQuery.fn.dataTableExt
	 */
	
	
	/*
	 * Variable: oJUIClasses
	 * Purpose:  Storage for the various classes that DataTables uses - jQuery UI suitable
	 * Scope:    jQuery.fn.dataTableExt
	 */
	_oExt.oJUIClasses = {
		/* Two buttons buttons */
		"sPagePrevEnabled": "fg-button ui-button ui-state-default ui-corner-left",
		"sPagePrevDisabled": "fg-button ui-button ui-state-default ui-corner-left ui-state-disabled",
		"sPageNextEnabled": "fg-button ui-button ui-state-default ui-corner-right",
		"sPageNextDisabled": "fg-button ui-button ui-state-default ui-corner-right ui-state-disabled",
		"sPageJUINext": "ui-icon ui-icon-circle-arrow-e",
		"sPageJUIPrev": "ui-icon ui-icon-circle-arrow-w",
		
		/* Full numbers paging buttons */
		"sPageButton": "fg-button ui-button ui-state-default",
		"sPageButtonActive": "fg-button ui-button ui-state-default ui-state-disabled",
		"sPageButtonStaticDisabled": "fg-button ui-button ui-state-default ui-state-disabled",
		"sPageFirst": "first ui-corner-tl ui-corner-bl",
		"sPagePrevious": "previous",
		"sPageNext": "next",
		"sPageLast": "last ui-corner-tr ui-corner-br",
		
		/* Stripping classes */
		"sStripOdd": "odd",
		"sStripEven": "even",
		
		/* Empty row */
		"sRowEmpty": "dataTables_empty",
		
		/* Features */
		"sWrapper": "dataTables_wrapper",
		"sFilter": "dataTables_filter",
		"sInfo": "dataTables_info",
		"sPaging": "dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi "+
			"ui-buttonset-multi paging_", /* Note that the type is postfixed */
		"sLength": "dataTables_length",
		"sProcessing": "dataTables_processing",
		
		/* Sorting */
		"sSortAsc": "ui-state-default",
		"sSortDesc": "ui-state-default",
		"sSortable": "ui-state-default",
		"sSortableAsc": "ui-state-default",
		"sSortableDesc": "ui-state-default",
		"sSortableNone": "ui-state-default",
		"sSortColumn": "sorting_", /* Note that an int is postfixed for the sorting order */
		"sSortJUIAsc": "dt-icon-sort css_right ui-icon ui-icon-triangle-1-n",
		"sSortJUIDesc": "dt-icon-sort css_right ui-icon ui-icon-triangle-1-s",
		"sSortJUI": "dt-icon-sort css_right ui-icon ui-icon-carat-2-n-s",
		"sSortJUIAscAllowed": "dt-icon-sort css_right ui-icon ui-icon-carat-1-n",
		"sSortJUIDescAllowed": "dt-icon-sort css_right ui-icon ui-icon-carat-1-s",
		"sSortJUIWrapper": "dataTables_sort_wrapper",
		
		/* Scrolling */
		"sScrollWrapper": "dataTables_scroll",
		"sScrollHead": "dataTables_scrollHead ui-state-default",
		"sScrollHeadInner": "dataTables_scrollHeadInner",
		"sScrollBody": "dataTables_scrollBody",
		"sScrollFoot": "dataTables_scrollFoot ui-state-default",
		"sScrollFootInner": "dataTables_scrollFootInner",
		
		/* Misc */
		"sFooterTH": "ui-state-default"
	};
	
	/*
	 * Variable: oPagination
	 * Purpose:  Container for the various type of pagination that dataTables supports
	 * Scope:    jQuery.fn.dataTableExt
	 */
	_oExt.oPagination = {
		/*
		 * Variable: two_button
		 * Purpose:  Standard two button (forward/back) pagination
	 	 * Scope:    jQuery.fn.dataTableExt.oPagination
		 */
		"two_button": {
			/*
			 * Function: oPagination.two_button.fnInit
			 * Purpose:  Initalise dom elements required for pagination with forward/back buttons only
			 * Returns:  -
	 		 * Inputs:   object:oSettings - dataTables settings object
	     *           node:nPaging - the DIV which contains this pagination control
			 *           function:fnCallbackDraw - draw function which must be called on update
			 */
			"fnInit": function ( oSettings, nPaging, fnCallbackDraw )
			{
				var nPrevious, nNext, nPreviousInner, nNextInner;
				
				/* Store the next and previous elements in the oSettings object as they can be very
				 * usful for automation - particularly testing
				 */
				nPrevious = document.createElement( 'a' );
				nNext = document.createElement( 'a' );
				
				nNextInner = document.createElement('span');
				nNextInner.className = oSettings.oClasses.sPageJUINext;
				nNext.appendChild( nNextInner );
				
				nPreviousInner = document.createElement('span');
				nPreviousInner.className = oSettings.oClasses.sPageJUIPrev;
				nPrevious.appendChild( nPreviousInner );

				
				nPrevious.className = oSettings.oClasses.sPagePrevDisabled;
				nNext.className = oSettings.oClasses.sPageNextDisabled;
				
				nPrevious.title = oSettings.oLanguage.oPaginate.sPrevious;
				nNext.title = oSettings.oLanguage.oPaginate.sNext;
				
				nPaging.appendChild( nPrevious );
				nPaging.appendChild( nNext );
				
				$(nPrevious).click( function() {
					if ( oSettings.oApi._fnPageChange( oSettings, "previous" ) )
					{
						/* Only draw when the page has actually changed */
						fnCallbackDraw( oSettings );
					}
				} );
				
				$(nNext).click( function() {
					if ( oSettings.oApi._fnPageChange( oSettings, "next" ) )
					{
						fnCallbackDraw( oSettings );
					}
				} );
				
				/* Take the brutal approach to cancelling text selection */
				$(nPrevious).bind( 'selectstart', function () { return false; } );
				$(nNext).bind( 'selectstart', function () { return false; } );
				
				/* ID the first elements only */
				if ( oSettings.sTableId !== '' && typeof oSettings.aanFeatures.p == "undefined" )
				{
					nPaging.setAttribute( 'id', oSettings.sTableId+'_paginate' );
					nPrevious.setAttribute( 'id', oSettings.sTableId+'_previous' );
					nNext.setAttribute( 'id', oSettings.sTableId+'_next' );
				}
			},
			
			/*
			 * Function: oPagination.two_button.fnUpdate
			 * Purpose:  Update the two button pagination at the end of the draw
			 * Returns:  -
	 		 * Inputs:   object:oSettings - dataTables settings object
			 *           function:fnCallbackDraw - draw function to call on page change
			 */
			"fnUpdate": function ( oSettings, fnCallbackDraw )
			{
				if ( !oSettings.aanFeatures.p )
				{
					return;
				}
				
				/* Loop over each instance of the pager */
				var an = oSettings.aanFeatures.p;
				for ( var i=0, iLen=an.length ; i<iLen ; i++ )
				{
					if ( an[i].childNodes.length !== 0 )
					{
						an[i].childNodes[0].className = 
							( oSettings._iDisplayStart === 0 ) ? 
							oSettings.oClasses.sPagePrevDisabled : oSettings.oClasses.sPagePrevEnabled;
						
						an[i].childNodes[1].className = 
							( oSettings.fnDisplayEnd() == oSettings.fnRecordsDisplay() ) ? 
							oSettings.oClasses.sPageNextDisabled : oSettings.oClasses.sPageNextEnabled;
					}
				}
			}
		},
		
		
		/*
		 * Variable: iFullNumbersShowPages
		 * Purpose:  Change the number of pages which can be seen
	 	 * Scope:    jQuery.fn.dataTableExt.oPagination
		 */
		"iFullNumbersShowPages": 5,
		
		/*
		 * Variable: full_numbers
		 * Purpose:  Full numbers pagination
	 	 * Scope:    jQuery.fn.dataTableExt.oPagination
		 */
		"full_numbers": {
			/*
			 * Function: oPagination.full_numbers.fnInit
			 * Purpose:  Initalise dom elements required for pagination with a list of the pages
			 * Returns:  -
	 		 * Inputs:   object:oSettings - dataTables settings object
	     *           node:nPaging - the DIV which contains this pagination control
			 *           function:fnCallbackDraw - draw function which must be called on update
			 */
			"fnInit": function ( oSettings, nPaging, fnCallbackDraw )
			{
				var nFirst = document.createElement( 'span' );
				var nPrevious = document.createElement( 'span' );
				var nList = document.createElement( 'span' );
				var nNext = document.createElement( 'span' );
				var nLast = document.createElement( 'span' );
				
				nFirst.innerHTML = oSettings.oLanguage.oPaginate.sFirst;
				nPrevious.innerHTML = oSettings.oLanguage.oPaginate.sPrevious;
				nNext.innerHTML = oSettings.oLanguage.oPaginate.sNext;
				nLast.innerHTML = oSettings.oLanguage.oPaginate.sLast;
				
				var oClasses = oSettings.oClasses;
				nFirst.className = oClasses.sPageButton+" "+oClasses.sPageFirst;
				nPrevious.className = oClasses.sPageButton+" "+oClasses.sPagePrevious;
				nNext.className= oClasses.sPageButton+" "+oClasses.sPageNext;
				nLast.className = oClasses.sPageButton+" "+oClasses.sPageLast;
				
				nPaging.appendChild( nFirst );
				nPaging.appendChild( nPrevious );
				nPaging.appendChild( nList );
				nPaging.appendChild( nNext );
				nPaging.appendChild( nLast );
				
				$(nFirst).click( function () {
					if ( oSettings.oApi._fnPageChange( oSettings, "first" ) )
					{
						fnCallbackDraw( oSettings );
					}
				} );
				
				$(nPrevious).click( function() {
					if ( oSettings.oApi._fnPageChange( oSettings, "previous" ) )
					{
						fnCallbackDraw( oSettings );
					}
				} );
				
				$(nNext).click( function() {
					if ( oSettings.oApi._fnPageChange( oSettings, "next" ) )
					{
						fnCallbackDraw( oSettings );
					}
				} );
				
				$(nLast).click( function() {
					if ( oSettings.oApi._fnPageChange( oSettings, "last" ) )
					{
						fnCallbackDraw( oSettings );
					}
				} );
				
				/* Take the brutal approach to cancelling text selection */
				$('span', nPaging)
					.bind( 'mousedown', function () { return false; } )
					.bind( 'selectstart', function () { return false; } );
				
				/* ID the first elements only */
				if ( oSettings.sTableId !== '' && typeof oSettings.aanFeatures.p == "undefined" )
				{
					nPaging.setAttribute( 'id', oSettings.sTableId+'_paginate' );
					nFirst.setAttribute( 'id', oSettings.sTableId+'_first' );
					nPrevious.setAttribute( 'id', oSettings.sTableId+'_previous' );
					nNext.setAttribute( 'id', oSettings.sTableId+'_next' );
					nLast.setAttribute( 'id', oSettings.sTableId+'_last' );
				}
			},
			
			/*
			 * Function: oPagination.full_numbers.fnUpdate
			 * Purpose:  Update the list of page buttons shows
			 * Returns:  -
	 		 * Inputs:   object:oSettings - dataTables settings object
			 *           function:fnCallbackDraw - draw function to call on page change
			 */
			"fnUpdate": function ( oSettings, fnCallbackDraw )
			{
				if ( !oSettings.aanFeatures.p )
				{
					return;
				}
				
				var iPageCount = _oExt.oPagination.iFullNumbersShowPages;
				var iPageCountHalf = Math.floor(iPageCount / 2);
				var iPages = Math.ceil((oSettings.fnRecordsDisplay()) / oSettings._iDisplayLength);
				var iCurrentPage = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1;
				var sList = "";
				var iStartButton, iEndButton, i, iLen;
				var oClasses = oSettings.oClasses;
				
				/* Pages calculation */
				if (iPages < iPageCount)
				{
					iStartButton = 1;
					iEndButton = iPages;
				}
				else
				{
					if (iCurrentPage <= iPageCountHalf)
					{
						iStartButton = 1;
						iEndButton = iPageCount;
					}
					else
					{
						if (iCurrentPage >= (iPages - iPageCountHalf))
						{
							iStartButton = iPages - iPageCount + 1;
							iEndButton = iPages;
						}
						else
						{
							iStartButton = iCurrentPage - Math.ceil(iPageCount / 2) + 1;
							iEndButton = iStartButton + iPageCount - 1;
						}
					}
				}
				
				/* Build the dynamic list */
				for ( i=iStartButton ; i<=iEndButton ; i++ )
				{
					if ( iCurrentPage != i )
					{
						sList += '<span class="'+oClasses.sPageButton+'">'+i+'</span>';
					}
					else
					{
						sList += '<span class="'+oClasses.sPageButtonActive+'">'+i+'</span>';
					}
				}
				
				/* Loop over each instance of the pager */
				var an = oSettings.aanFeatures.p;
				var anButtons, anStatic, nPaginateList;
				var fnClick = function() {
					/* Use the information in the element to jump to the required page */
					var iTarget = (this.innerHTML * 1) - 1;
					oSettings._iDisplayStart = iTarget * oSettings._iDisplayLength;
					fnCallbackDraw( oSettings );
					return false;
				};
				var fnFalse = function () { return false; };
				
				for ( i=0, iLen=an.length ; i<iLen ; i++ )
				{
					if ( an[i].childNodes.length === 0 )
					{
						continue;
					}
					
					/* Build up the dynamic list forst - html and listeners */
					var qjPaginateList = $('span:eq(2)', an[i]);
					qjPaginateList.html( sList );
					$('span', qjPaginateList).click( fnClick ).bind( 'mousedown', fnFalse )
						.bind( 'selectstart', fnFalse );
					
					/* Update the 'premanent botton's classes */
					anButtons = an[i].getElementsByTagName('span');
					anStatic = [
						anButtons[0], anButtons[1], 
						anButtons[anButtons.length-2], anButtons[anButtons.length-1]
					];
					$(anStatic).removeClass( oClasses.sPageButton+" "+oClasses.sPageButtonActive+" "+oClasses.sPageButtonStaticDisabled );
					if ( iCurrentPage == 1 )
					{
						anStatic[0].className += " "+oClasses.sPageButtonStaticDisabled;
						anStatic[1].className += " "+oClasses.sPageButtonStaticDisabled;
					}
					else
					{
						anStatic[0].className += " "+oClasses.sPageButton;
						anStatic[1].className += " "+oClasses.sPageButton;
					}
					
					if ( iPages === 0 || iCurrentPage == iPages || oSettings._iDisplayLength == -1 )
					{
						anStatic[2].className += " "+oClasses.sPageButtonStaticDisabled;
						anStatic[3].className += " "+oClasses.sPageButtonStaticDisabled;
					}
					else
					{
						anStatic[2].className += " "+oClasses.sPageButton;
						anStatic[3].className += " "+oClasses.sPageButton;
					}
				}
			}
		}
	};
	
	/*
	 * Variable: oSort
	 * Purpose:  Wrapper for the sorting functions that can be used in DataTables
	 * Scope:    jQuery.fn.dataTableExt
	 * Notes:    The functions provided in this object are basically standard javascript sort
	 *   functions - they expect two inputs which they then compare and then return a priority
	 *   result. For each sort method added, two functions need to be defined, an ascending sort and
	 *   a descending sort.
	 */
	_oExt.oSort = {
		/*
		 * text sorting
		 */
		"string-asc": function ( a, b )
		{
			var x = a.toLowerCase();
			var y = b.toLowerCase();
			return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		},
		
		"string-desc": function ( a, b )
		{
			var x = a.toLowerCase();
			var y = b.toLowerCase();
			return ((x < y) ? 1 : ((x > y) ? -1 : 0));
		},
		
		
		/*
		 * html sorting (ignore html tags)
		 */
		"html-asc": function ( a, b )
		{
			var x = a.replace( /<.*?>/g, "" ).toLowerCase();
			var y = b.replace( /<.*?>/g, "" ).toLowerCase();
			return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		},
		
		"html-desc": function ( a, b )
		{
			var x = a.replace( /<.*?>/g, "" ).toLowerCase();
			var y = b.replace( /<.*?>/g, "" ).toLowerCase();
			return ((x < y) ? 1 : ((x > y) ? -1 : 0));
		},
		
		
		/*
		 * date sorting
		 */
		"date-asc": function ( a, b )
		{
			var months = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
			
			if(a == b)
				return 0;
			x = a.split(" ");
			y = b.split(" ");
			date_a = new Date(x[2],jQuery.inArray(x[1]), x[0]);
			date_b = new Date(y[2],jQuery.inArray(y[1]), y[0]);
			return date_a > date_b? 1 : -1;
		},
		
		"date-desc": function ( a, b )
		{
			var months = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
			
			if(a == b)
				return 0;
			x = a.split(" ");
			y = b.split(" ");
			date_a = new Date(x[2],jQuery.inArray(x[1]), x[0]);
			date_b = new Date(y[2],jQuery.inArray(y[1]), y[0]);
			return date_a > date_b? -1 : 1;
		},
    
    /*
		 * date sorting
		 */
		"strdate-asc": function ( a, b )
		{
			var months = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
			
			if(a == b)
				return 0;
			x = a.split(" ");
			y = b.split(" ");
			date_a = new Date(x[2],$.inArray(x[0], months), x[1]);
			date_b = new Date(y[2],$.inArray(y[0], months), y[1]);
			return date_a > date_b? 1 : -1;
		},
		
		"strdate-desc": function ( a, b )
		{
			var months = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
			
			if(a == b)
				return 0;
			x = a.split(" ");
			y = b.split(" ");
			date_a = new Date(x[2],$.inArray(x[0], months), x[1]);
			date_b = new Date(y[2],$.inArray(y[0], months), y[1]);
			return date_a > date_b? -1 : 1;
		},
		
		
		/*
		 * numerical sorting
		 */
		"numeric-asc": function ( a, b )
		{
      a = parseFloat(new String(""+a).replace(",","."));
      b = parseFloat(new String(""+b).replace(",","."));
			var x = (a=="-" || a==="") ? 0 : a*1;
			var y = (b=="-" || b==="") ? 0 : b*1;
			return x - y;
		},
		
		"numeric-desc": function ( a, b )
		{
      a = parseFloat(new String(""+a).replace(",","."));
      b = parseFloat(new String(""+b).replace(",","."));
			var x = (a=="-" || a==="") ? 0 : a*1;
			var y = (b=="-" || b==="") ? 0 : b*1;
			return y - x;
		},
		"percent-asc": function(a,b){
			var x = parseInt(a.replace("%",""));
			var y = parseInt(b.replace("%",""));
			if(x == y)
				return 0;
			return x > y ? 1:-1;
			
		},
		"percent-desc": function(a,b){
			var x = parseInt(a.replace("%",""));
			var y = parseInt(b.replace("%",""));
			if(x == y)
				return 0;
			return x < y ? 1:-1;
		},
	};
	
	
	/*
	 * Variable: aTypes
	 * Purpose:  Container for the various type of type detection that dataTables supports
	 * Scope:    jQuery.fn.dataTableExt
	 * Notes:    The functions in this array are expected to parse a string to see if it is a data
	 *   type that it recognises. If so then the function should return the name of the type (a
	 *   corresponding sort function should be defined!), if the type is not recognised then the
	 *   function should return null such that the parser and move on to check the next type.
	 *   Note that ordering is important in this array - the functions are processed linearly,
	 *   starting at index 0.
	 *   Note that the input for these functions is always a string! It cannot be any other data
	 *   type
	 */
	_oExt.aTypes = [
    function(sData){
      return (/^\d*(,\d*)?$/.test(sData))? "numeric":null;
      
    },
		/*
		 * Function: -
		 * Purpose:  Check to see if a string is numeric
		 * Returns:  string:'numeric' or null
		 * Inputs:   string:sText - string to check
		 */
		function ( sData )
		{
			/* Allow zero length strings as a number */
			if ( sData.length === 0 )
			{
				return 'numeric';
			}
      
      return isNaN(parseFloat(sData)) ? null : 'numeric'
			
			var sValidFirstChars = "0123456789-";
			var sValidChars = "0123456789.";
			var Char;
			var bDecimal = false;
			
			/* Check for a valid first char (no period and allow negatives) */
			Char = sData.charAt(0); 
			if (sValidFirstChars.indexOf(Char) == -1) 
			{
				return null;
			}
			
			/* Check all the other characters are valid */
			for ( var i=1 ; i<sData.length ; i++ ) 
			{
				Char = sData.charAt(i); 
				if (sValidChars.indexOf(Char) == -1) 
				{
					return null;
				}
				
				/* Only allowed one decimal place... */
				if ( Char == "." )
				{
					if ( bDecimal )
					{
						return null;
					}
					bDecimal = true;
				}
			}
			
			return 'numeric';
		},
		
		/*
		 * Function: -
		 * Purpose:  Check to see if a string is actually a formatted date
		 * Returns:  string:'date' or null
		 * Inputs:   string:sText - string to check
		 */
		function ( sData )
		{
			var months = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
			var pattern = new RegExp("^\\s*("+months.join("|")+")\\s\\d{2}\\s\\d{4}\\s*$");
			return (pattern.test(sData))? "strdate" : null;
		},
		
		/*
		 * Function: -
		 * Purpose:  Check to see if a string should be treated as an HTML string
		 * Returns:  string:'html' or null
		 * Inputs:   string:sText - string to check
		 */
		function ( sData ){
			return /<.+>/.test(sData)? 'html': null;
		},
		function (sData){
			return /\d+(\.\d+)?%/.test(sData)?'percent':null;
		}
		
	];
	
	/*
	 * Function: fnVersionCheck
	 * Purpose:  Check a version string against this version of DataTables. Useful for plug-ins
	 * Returns:  bool:true -this version of DataTables is greater or equal to the required version
	 *                false -this version of DataTales is not suitable
	 * Inputs:   string:sVersion - the version to check against. May be in the following formats:
	 *             "a", "a.b" or "a.b.c"
	 * Notes:    This function will only check the first three parts of a version string. It is
	 *   assumed that beta and dev versions will meet the requirements. This might change in future
	 */
	_oExt.fnVersionCheck = function( sVersion )
	{
		/* This is cheap, but very effective */
		var fnZPad = function (Zpad, count)
		{
			while(Zpad.length < count) {
				Zpad += '0';
			}
			return Zpad;
		};
		var aThis = _oExt.sVersion.split('.');
		var aThat = sVersion.split('.');
		var sThis = '', sThat = '';
		
		for ( var i=0, iLen=aThat.length ; i<iLen ; i++ )
		{
			sThis += fnZPad( aThis[i], 3 );
			sThat += fnZPad( aThat[i], 3 );
		}
		
		return parseInt(sThis, 10) >= parseInt(sThat, 10);
	};
	
	/*
	 * Variable: _oExternConfig
	 * Purpose:  Store information for DataTables to access globally about other instances
	 * Scope:    jQuery.fn.dataTableExt
	 */
	_oExt._oExternConfig = {
		/* int:iNextUnique - next unique number for an instance */
		"iNextUnique": 0
	};
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Section - DataTables prototype
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/*
	 * Function: dataTable
	 * Purpose:  DataTables information
	 * Returns:  -
	 * Inputs:   object:oInit - initalisation options for the table
	 */
	$.fn.dataTable = function( oInit )
	{
		$(this).data('hasDataTable', true);
		/*
		 * Function: classSettings
		 * Purpose:  Settings container function for all 'class' properties which are required
		 *   by dataTables
		 * Returns:  -
		 * Inputs:   -
		 */
		function classSettings ()
		{
			this.fnRecordsTotal = function ()
			{
				if ( this.oFeatures.bServerSide ) {
					return parseInt(this._iRecordsTotal, 10);
				} else {
					return this.aiDisplayMaster.length;
				}
			};
			
			this.fnRecordsDisplay = function ()
			{
				if ( this.oFeatures.bServerSide ) {
					return parseInt(this._iRecordsDisplay, 10);
				} else {
					return this.aiDisplay.length;
				}
			};
			
			this.fnDisplayEnd = function ()
			{
				if ( this.oFeatures.bServerSide ) {
					if ( this.oFeatures.bPaginate === false || this._iDisplayLength == -1 ) {
						return this._iDisplayStart+this.aiDisplay.length;
					} else {
						return Math.min( this._iDisplayStart+this._iDisplayLength, 
							this._iRecordsDisplay );
					}
				} else {
					return this._iDisplayEnd;
				}
			};
			
			/*
			 * Variable: oInstance
			 * Purpose:  The DataTables object for this table
			 * Scope:    jQuery.dataTable.classSettings 
			 */
			this.oInstance = null;
			
			/*
			 * Variable: sInstance
			 * Purpose:  Unique idendifier for each instance of the DataTables object
			 * Scope:    jQuery.dataTable.classSettings 
			 */
			this.sInstance = null;
			
			/*
			 * Variable: oFeatures
			 * Purpose:  Indicate the enablement of key dataTable features
			 * Scope:    jQuery.dataTable.classSettings 
			 */
			this.oFeatures = {
				"bPaginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": false,
				"bProcessing": false,
				"bSortClasses": true,
				"bStateSave": false,
				"bServerSide": false
			};
			
			/*
			 * Variable: oScroll
			 * Purpose:  Container for scrolling options
			 * Scope:    jQuery.dataTable.classSettings 
			 */
			this.oScroll = {
				"sX": "",
				"sXInner": "",
				"sY": "",
				"bCollapse": false,
				"bInfinite": false,
				"iLoadGap": 100,
				"iBarWidth": 0,
				"bAutoCss": true
			};
			
			/*
			 * Variable: aanFeatures
			 * Purpose:  Array referencing the nodes which are used for the features
			 * Scope:    jQuery.dataTable.classSettings 
			 * Notes:    The parameters of this object match what is allowed by sDom - i.e.
			 *   'l' - Length changing
			 *   'f' - Filtering input
			 *   't' - The table!
			 *   'i' - Information
			 *   'p' - Pagination
			 *   'r' - pRocessing
			 */
			this.aanFeatures = [];
			
			/*
			 * Variable: oLanguage
			 * Purpose:  Store the language strings used by dataTables
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    The words in the format _VAR_ are variables which are dynamically replaced
			 *   by javascript
			 */
			this.oLanguage = {
				"sProcessing": "Cargando...",
				"sLengthMenu": "Mostrar _MENU_ ",
				"sZeroRecords": "0 registros",
				"sEmptyTable": "La tabla está vacía",
				"sInfo": "  Desde _START_ hasta _END_ de _TOTAL_",
				"sInfoEmpty": "0 items",
				"sInfoFiltered": "(* _MAX_ registros)",
				"sInfoPostFix": "",
				"sSearch": "Buscar:",
				"sUrl": "",
				"oPaginate": {
					"sFirst":    "|<",
					"sPrevious": "\u00AB",
					"sNext":     "\u00BB",
					"sLast":     ">|"
				},
				"fnInfoCallback": null
			};
			
			/*
			 * Variable: aoData
			 * Purpose:  Store data information
			 * Scope:    jQuery.dataTable.classSettings 
			 * Notes:    This is an array of objects with the following parameters:
			 *   int: _iId - internal id for tracking
			 *   array: _aData - internal data - used for sorting / filtering etc
			 *   node: nTr - display node
			 *   array node: _anHidden - hidden TD nodes
			 *   string: _sRowStripe
			 */
			this.aoData = [];
			
			/*
			 * Variable: aiDisplay
			 * Purpose:  Array of indexes which are in the current display (after filtering etc)
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.aiDisplay = [];
			
			/*
			 * Variable: aiDisplayMaster
			 * Purpose:  Array of indexes for display - no filtering
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.aiDisplayMaster = [];
							
			/*
			 * Variable: aoColumns
			 * Purpose:  Store information about each column that is in use
			 * Scope:    jQuery.dataTable.classSettings 
			 */
			this.aoColumns = [];
			
			/*
			 * Variable: iNextId
			 * Purpose:  Store the next unique id to be used for a new row
			 * Scope:    jQuery.dataTable.classSettings 
			 */
			this.iNextId = 0;
			
			/*
			 * Variable: asDataSearch
			 * Purpose:  Search data array for regular expression searching
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.asDataSearch = [];
			
			/*
			 * Variable: oPreviousSearch
			 * Purpose:  Store the previous search incase we want to force a re-search
			 *   or compare the old search to a new one
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.oPreviousSearch = {
				"sSearch": "",
				"bRegex": false,
				"bSmart": true
			};
			
			/*
			 * Variable: aoPreSearchCols
			 * Purpose:  Store the previous search for each column
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.aoPreSearchCols = [];
			
			/*
			 * Variable: aaSorting
			 * Purpose:  Sorting information
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    Index 0 - column number
			 *           Index 1 - current sorting direction
			 *           Index 2 - index of asSorting for this column
			 */
			this.aaSorting = [ [0, 'asc', 0] ];
			
			/*
			 * Variable: aaSortingFixed
			 * Purpose:  Sorting information that is always applied
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.aaSortingFixed = null;
			
			/*
			 * Variable: asStripClasses
			 * Purpose:  Classes to use for the striping of a table
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.asStripClasses = [];
			
			/*
			 * Variable: asDestoryStrips
			 * Purpose:  If restoring a table - we should restore it's striping classes as well
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.asDestoryStrips = [];
			
			/*
			 * Variable: sDestroyWidth
			 * Purpose:  If restoring a table - we should restore it's width
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.sDestroyWidth = 0;
			
			/*
			 * Variable: fnRowCallback
			 * Purpose:  Call this function every time a row is inserted (draw)
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.fnRowCallback = null;
			
			/*
			 * Variable: fnHeaderCallback
			 * Purpose:  Callback function for the header on each draw
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.fnHeaderCallback = null;
			
			/*
			 * Variable: fnFooterCallback
			 * Purpose:  Callback function for the footer on each draw
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.fnFooterCallback = null;
			
			/*
			 * Variable: aoDrawCallback
			 * Purpose:  Array of callback functions for draw callback functions
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    Each array element is an object with the following parameters:
			 *   function:fn - function to call
			 *   string:sName - name callback (feature). useful for arranging array
			 */
			this.aoDrawCallback = [];
			
			/*
			 * Variable: fnInitComplete
			 * Purpose:  Callback function for when the table has been initalised
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.fnInitComplete = null;
			
			/*
			 * Variable: sTableId
			 * Purpose:  Cache the table ID for quick access
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.sTableId = "";
			
			/*
			 * Variable: nTable
			 * Purpose:  Cache the table node for quick access
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.nTable = null;
			
			/*
			 * Variable: nTHead
			 * Purpose:  Permanent ref to the thead element
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.nTHead = null;
			
			/*
			 * Variable: nTFoot
			 * Purpose:  Permanent ref to the tfoot element - if it exists
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.nTFoot = null;
			
			/*
			 * Variable: nTBody
			 * Purpose:  Permanent ref to the tbody element
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.nTBody = null;
			
			/*
			 * Variable: nTableWrapper
			 * Purpose:  Cache the wrapper node (contains all DataTables controlled elements)
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.nTableWrapper = null;
			
			/*
			 * Variable: bInitialised
			 * Purpose:  Indicate if all required information has been read in
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.bInitialised = false;
			
			/*
			 * Variable: aoOpenRows
			 * Purpose:  Information about open rows
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    Has the parameters 'nTr' and 'nParent'
			 */
			this.aoOpenRows = [];
			
			/*
			 * Variable: sDom
			 * Purpose:  Dictate the positioning that the created elements will take
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    
			 *   The following options are allowed:
			 *     'l' - Length changing
			 *     'f' - Filtering input
			 *     't' - The table!
			 *     'i' - Information
			 *     'p' - Pagination
			 *     'r' - pRocessing
			 *   The following constants are allowed:
			 *     'H' - jQueryUI theme "header" classes
			 *     'F' - jQueryUI theme "footer" classes
			 *   The following syntax is expected:
			 *     '<' and '>' - div elements
			 *     '<"class" and '>' - div with a class
			 *   Examples:
			 *     '<"wrapper"flipt>', '<lf<t>ip>'
			 */

			this.sDom = '<"H"TflG>rt<"F"Cip>';
			
			
			/*
			 * Variable: sPaginationType
			 * Purpose:  Note which type of sorting should be used
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.sPaginationType = "two_button";
			
			/*
			 * Variable: iCookieDuration
			 * Purpose:  The cookie duration (for bStateSave) in seconds - default 2 hours
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.iCookieDuration = 60 * 60 * 2;
			
			/*
			 * Variable: sCookiePrefix
			 * Purpose:  The cookie name prefix
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.sCookiePrefix = "SpryMedia_DataTables_";
			
			/*
			 * Variable: fnCookieCallback
			 * Purpose:  Callback function for cookie creation
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.fnCookieCallback = null;
			
			/*
			 * Variable: aoStateSave
			 * Purpose:  Array of callback functions for state saving
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    Each array element is an object with the following parameters:
			 *   function:fn - function to call. Takes two parameters, oSettings and the JSON string to
			 *     save that has been thus far created. Returns a JSON string to be inserted into a 
			 *     json object (i.e. '"param": [ 0, 1, 2]')
			 *   string:sName - name of callback
			 */
			this.aoStateSave = [];
			
			/*
			 * Variable: aoStateLoad
			 * Purpose:  Array of callback functions for state loading
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    Each array element is an object with the following parameters:
			 *   function:fn - function to call. Takes two parameters, oSettings and the object stored.
			 *     May return false to cancel state loading.
			 *   string:sName - name of callback
			 */
			this.aoStateLoad = [];
			
			/*
			 * Variable: oLoadedState
			 * Purpose:  State that was loaded from the cookie. Useful for back reference
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.oLoadedState = null;
			
			/*
			 * Variable: sAjaxSource
			 * Purpose:  Source url for AJAX data for the table
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.sAjaxSource = null;
			
			/*
			 * Variable: bAjaxDataGet
			 * Purpose:  Note if draw should be blocked while getting data
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.bAjaxDataGet = true;
			
			/*
			 * Variable: fnServerData
			 * Purpose:  Function to get the server-side data - can be overruled by the developer
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.fnServerData = function ( url, data, callback ) {
				$.ajax( {
					"url": url,
					"data": data,
					"success": callback,
					"dataType": "json",
					"cache": false,
					"error": function (xhr, error, thrown) {
						if ( error == "parsererror" ) {
							alert( "DataTables warning: JSON data from server could not be parsed. "+
								"This is caused by a JSON formatting error." );
						}
					}
				} );
			};
			
			/*
			 * Variable: fnFormatNumber
			 * Purpose:  Format numbers for display
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.fnFormatNumber = function ( iIn )
			{
				if ( iIn < 1000 )
				{
					/* A small optimisation for what is likely to be the vast majority of use cases */
					return iIn;
				}
				else
				{
					var s=(iIn+""), a=s.split(""), out="", iLen=s.length;
					
					for ( var i=0 ; i<iLen ; i++ )
					{
						if ( i%3 === 0 && i !== 0 )
						{
							out = ','+out;
						}
						out = a[iLen-i-1]+out;
					}
				}
				return out;
			};
			
			/*
			 * Variable: aLengthMenu
			 * Purpose:  List of options that can be used for the user selectable length menu
			 * Scope:    jQuery.dataTable.classSettings
			 * Note:     This varaible can take for form of a 1D array, in which case the value and the 
			 *   displayed value in the menu are the same, or a 2D array in which case the value comes
			 *   from the first array, and the displayed value to the end user comes from the second
			 *   array. 2D example: [ [ 10, 25, 50, 100, -1 ], [ 10, 25, 50, 100, 'All' ] ];
			 */
			this.aLengthMenu = [ 50, 100,500,1000,-1 ];
			
			/*
			 * Variable: iDraw
			 * Purpose:  Counter for the draws that the table does. Also used as a tracker for
			 *   server-side processing
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.iDraw = 0;
			
			/*
			 * Variable: bDrawing
			 * Purpose:  Indicate if a redraw is being done - useful for Ajax
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.bDrawing = 0;
			
			/*
			 * Variable: iDrawError
			 * Purpose:  Last draw error
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.iDrawError = -1;
			
			/*
			 * Variable: _iDisplayLength, _iDisplayStart, _iDisplayEnd
			 * Purpose:  Display length variables
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    These variable must NOT be used externally to get the data length. Rather, use
			 *   the fnRecordsTotal() (etc) functions.
			 */
			this._iDisplayLength = 50;
			this._iDisplayStart = 0;
			this._iDisplayEnd = 50;
			
			/*
			 * Variable: _iRecordsTotal, _iRecordsDisplay
			 * Purpose:  Display length variables used for server side processing
			 * Scope:    jQuery.dataTable.classSettings
			 * Notes:    These variable must NOT be used externally to get the data length. Rather, use
			 *   the fnRecordsTotal() (etc) functions.
			 */
			this._iRecordsTotal = 0;
			this._iRecordsDisplay = 0;
			
			/*
			 * Variable: bJUI
			 * Purpose:  Should we add the markup needed for jQuery UI theming?
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.bJUI = true;
			
			/*
			 * Variable: bJUI
			 * Purpose:  Should we add the markup needed for jQuery UI theming?
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.oClasses = _oExt.oJUIClasses;
			
			/*
			 * Variable: bFiltered and bSorted
			 * Purpose:  Flags to allow callback functions to see what actions have been performed
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.bFiltered = false;
			this.bSorted = false;
			
			/*
			 * Variable: oInit
			 * Purpose:  Initialisation object that is used for the table
			 * Scope:    jQuery.dataTable.classSettings
			 */
			this.oInit = null;
		}
		
		/*
		 * Variable: oApi
		 * Purpose:  Container for publicly exposed 'private' functions
		 * Scope:    jQuery.dataTable
		 */
		this.oApi = {};
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - API functions
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		
		/*
		 * Function: fnDraw
		 * Purpose:  Redraw the table
		 * Returns:  -
		 * Inputs:   bool:bComplete - Refilter and resort (if enabled) the table before the draw.
		 *             Optional: default - true
		 */
		this.fnDraw = function( bComplete )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			if ( typeof bComplete != 'undefined' && bComplete === false )
			{
				_fnCalculateEnd( oSettings );
				_fnDraw( oSettings );
			}
			else
			{
				_fnReDraw( oSettings );
			}
		};
		
		/*
		 * Function: fnFilter
		 * Purpose:  Filter the input based on data
		 * Returns:  -
		 * Inputs:   string:sInput - string to filter the table on
		 *           int:iColumn - optional - column to limit filtering to
		 *           bool:bRegex - optional - treat as regular expression or not - default false
		 *           bool:bSmart - optional - perform smart filtering or not - default true
		 *           bool:bShowGlobal - optional - show the input global filter in it's input box(es)
		 *              - default true
		 */
		this.fnFilter = function( sInput, iColumn, bRegex, bSmart, bShowGlobal )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			
			if ( !oSettings.oFeatures.bFilter )
			{
				return;
			}
			
			if ( typeof bRegex == 'undefined' )
			{
				bRegex = false;
			}
			
			if ( typeof bSmart == 'undefined' )
			{
				bSmart = true;
			}
			
			if ( typeof bShowGlobal == 'undefined' )
			{
				bShowGlobal = true;
			}
			
			if ( typeof iColumn == "undefined" || iColumn === null )
			{
				/* Global filter */
				_fnFilterComplete( oSettings, {
					"sSearch":sInput,
					"bRegex": bRegex,
					"bSmart": bSmart
				}, 1 );
				
				if ( bShowGlobal && typeof oSettings.aanFeatures.f != 'undefined' )
				{
					var n = oSettings.aanFeatures.f;
					for ( var i=0, iLen=n.length ; i<iLen ; i++ )
					{
						$('input', n[i]).val( sInput );
					}
				}
			}
			else
			{
				if(iColumn < 0)
					iColumn = oSettings.aoPreSearchCols.length + iColumn;
				/* Single column filter */
				oSettings.aoPreSearchCols[ iColumn ].sSearch = sInput;
				oSettings.aoPreSearchCols[ iColumn ].bRegex = bRegex;
				oSettings.aoPreSearchCols[ iColumn ].bSmart = bSmart;
				_fnFilterComplete( oSettings, oSettings.oPreviousSearch, 1 );
			}
		};
		
		/*
		 * Function: fnSettings
		 * Purpose:  Get the settings for a particular table for extern. manipulation
		 * Returns:  -
		 * Inputs:   -
		 */
		this.fnSettings = function( nNode  )
		{
			return _fnSettingsFromNode( this[_oExt.iApiIndex] );
		};
		
		/*
		 * Function: fnVersionCheck
		 * Notes:    The function is the same as the 'static' function provided in the ext variable
		 */
		this.fnVersionCheck = _oExt.fnVersionCheck;
		
		/*
		 * Function: fnSort
		 * Purpose:  Sort the table by a particular row
		 * Returns:  -
		 * Inputs:   int:iCol - the data index to sort on. Note that this will
		 *   not match the 'display index' if you have hidden data entries
		 */
		this.fnSort = function( aaSort )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			oSettings.aaSorting = aaSort;
			_fnSort( oSettings );
		};
		
		/*
		 * Function: fnSortListener
		 * Purpose:  Attach a sort listener to an element for a given column
		 * Returns:  -
		 * Inputs:   node:nNode - the element to attach the sort listener to
		 *           int:iColumn - the column that a click on this node will sort on
		 *           function:fnCallback - callback function when sort is run - optional
		 */
		this.fnSortListener = function( nNode, iColumn, fnCallback )
		{
			_fnSortAttachListener( _fnSettingsFromNode( this[_oExt.iApiIndex] ), nNode, iColumn,
			 	fnCallback );
		};
		
		/*
		 * Function: fnAddData
		 * Purpose:  Add new row(s) into the table
		 * Returns:  array int: array of indexes (aoData) which have been added (zero length on error)
		 * Inputs:   array:mData - the data to be added. The length must match
		 *               the original data from the DOM
		 *             or
		 *             array array:mData - 2D array of data to be added
		 *           bool:bRedraw - redraw the table or not - default true
		 * Notes:    Warning - the refilter here will cause the table to redraw
		 *             starting at zero
		 * Notes:    Thanks to Yekimov Denis for contributing the basis for this function!
		 */
		this.fnAddData = function( mData, bRedraw )
		{
			if ( mData.length === 0 )
			{
				return [];
			}
			
			var aiReturn = [];
			var iTest;
			
			/* Find settings from table node */
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			
			/* Check if we want to add multiple rows or not */
			if ( typeof mData[0] == "object" )
			{
				for ( var i=0 ; i<mData.length ; i++ )
				{
					iTest = _fnAddData( oSettings, mData[i] );
					if ( iTest == -1 )
					{
						return aiReturn;
					}
					aiReturn.push( iTest );
				}
			}
			else
			{
				iTest = _fnAddData( oSettings, mData );
				if ( iTest == -1 )
				{
					return aiReturn;
				}
				aiReturn.push( iTest );
			}
			
			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			
			if ( typeof bRedraw == 'undefined' || bRedraw )
			{
				_fnReDraw( oSettings );
			}
			return aiReturn;
		};
		
		/*
		 * Function: fnDeleteRow
		 * Purpose:  Remove a row for the table
		 * Returns:  array:aReturn - the row that was deleted
		 * Inputs:   mixed:mTarget - 
		 *             int: - index of aoData to be deleted, or
		 *             node(TR): - TR element you want to delete
		 *           function:fnCallBack - callback function - default null
		 *           bool:bRedraw - redraw the table or not - default true
		 */
		this.fnDeleteRow = function( mTarget, fnCallBack, bRedraw )
		{
			/* Find settings from table node */
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			var i, iAODataIndex;
			
			iAODataIndex = (typeof mTarget == 'object') ? 
				_fnNodeToDataIndex(oSettings, mTarget) : mTarget;
			
			/* Return the data array from this row */
			var oData = oSettings.aoData.splice( iAODataIndex, 1 );
			
			/* Remove the target row from the search array */
			var iDisplayIndex = $.inArray( iAODataIndex, oSettings.aiDisplay );
			oSettings.asDataSearch.splice( iDisplayIndex, 1 );
			
			/* Delete from the display arrays */
			_fnDeleteIndex( oSettings.aiDisplayMaster, iAODataIndex );
			_fnDeleteIndex( oSettings.aiDisplay, iAODataIndex );
			
			/* If there is a user callback function - call it */
			if ( typeof fnCallBack == "function" )
			{
				fnCallBack.call( this, oSettings, oData );
			}
			
			/* Check for an 'overflow' they case for dislaying the table */
			if ( oSettings._iDisplayStart >= oSettings.aiDisplay.length )
			{
				oSettings._iDisplayStart -= oSettings._iDisplayLength;
				if ( oSettings._iDisplayStart < 0 )
				{
					oSettings._iDisplayStart = 0;
				}
			}
			
			if ( typeof bRedraw == 'undefined' || bRedraw )
			{
				_fnCalculateEnd( oSettings );
				_fnDraw( oSettings );
			}
			
			return oData;
		};
		
		/*
		 * Function: fnClearTable
		 * Purpose:  Quickly and simply clear a table
		 * Returns:  -
		 * Inputs:   bool:bRedraw - redraw the table or not - default true
		 * Notes:    Thanks to Yekimov Denis for contributing the basis for this function!
		 */
		this.fnClearTable = function( bRedraw )
		{
			/* Find settings from table node */
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			_fnClearTable( oSettings );
			
			if ( typeof bRedraw == 'undefined' || bRedraw )
			{
				_fnDraw( oSettings );
			}
		};
		
		/*
		 * Function: fnOpen
		 * Purpose:  Open a display row (append a row after the row in question)
		 * Returns:  node:nNewRow - the row opened
		 * Inputs:   node:nTr - the table row to 'open'
		 *           string:sHtml - the HTML to put into the row
		 *           string:sClass - class to give the new TD cell
		 */
		this.fnOpen = function( nTr, sHtml, sClass )
		{
			/* Find settings from table node */
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			
			/* the old open one if there is one */
			this.fnClose( nTr );
			
			var nNewRow = document.createElement("tr");
			var nNewCell = document.createElement("td");
			nNewRow.appendChild( nNewCell );
			nNewCell.className = "dt-expandable-cell " + sClass;
			nNewCell.colSpan = _fnVisbleColumns( oSettings );
			nNewCell.innerHTML = sHtml;
			
			/* If the nTr isn't on the page at the moment - then we don't insert at the moment */
			var nTrs = $('tr', oSettings.nTBody);
			if ( $.inArray(nTr, nTrs) != -1 )
			{
				$(nNewRow).insertAfter(nTr);
			}
			
			oSettings.aoOpenRows.push( {
				"nTr": nNewRow,
				"nParent": nTr
			} );
			
			return nNewRow;
		};
		
		/*
		 * Function: fnClose
		 * Purpose:  Close a display row
		 * Returns:  int: 0 (success) or 1 (failed)
		 * Inputs:   node:nTr - the table row to 'close'
		 */
		this.fnClose = function( nTr )
		{
			/* Find settings from table node */
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			
			for ( var i=0 ; i<oSettings.aoOpenRows.length ; i++ )
			{
				if ( oSettings.aoOpenRows[i].nParent == nTr )
				{
					var nTrParent = oSettings.aoOpenRows[i].nTr.parentNode;
					if ( nTrParent )
					{
						/* Remove it if it is currently on display */
						nTrParent.removeChild( oSettings.aoOpenRows[i].nTr );
					}
					oSettings.aoOpenRows.splice( i, 1 );
					return 0;
				}
			}
			return 1;
		};
		
		/*
		 * Function: fnGetData
		 * Purpose:  Return an array with the data which is used to make up the table
		 * Returns:  array array string: 2d data array ([row][column]) or array string: 1d data array
		 *           or
		 *           array string (if iRow specified)
		 * Inputs:   mixed:mRow - optional - if not present, then the full 2D array for the table 
		 *             if given then:
		 *               int: - return 1D array for aoData entry of this index
		 *               node(TR): - return 1D array for this TR element
		 * Inputs:   int:iRow - optional - if present then the array returned will be the data for
		 *             the row with the index 'iRow'
		 */
		this.fnGetData = function( mRow )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			
			if ( typeof mRow != 'undefined' )
			{
				var iRow = (typeof mRow == 'object') ? 
					_fnNodeToDataIndex(oSettings, mRow) : mRow;
				return oSettings.aoData[iRow]._aData;
			}
			return _fnGetDataMaster( oSettings );
		};
		
		/*
		 * Function: fnGetNodes
		 * Purpose:  Return an array with the TR nodes used for drawing the table
		 * Returns:  array node: TR elements
		 *           or
		 *           node (if iRow specified)
		 * Inputs:   int:iRow - optional - if present then the array returned will be the node for
		 *             the row with the index 'iRow'
		 */
		this.fnGetNodes = function( iRow )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			
			if ( typeof iRow != 'undefined' )
			{
				return oSettings.aoData[iRow].nTr;
			}
			return _fnGetTrNodes( oSettings );
		};
		
		/*
		 * Function: fnGetPosition
		 * Purpose:  Get the array indexes of a particular cell from it's DOM element
		 * Returns:  int: - row index, or array[ int, int, int ]: - row index, column index (visible)
		 *             and column index including hidden columns
		 * Inputs:   node:nNode - this can either be a TR or a TD in the table, the return is
		 *             dependent on this input
		 */
		this.fnGetPosition = function( nNode )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			var i;
			
			if ( nNode.nodeName.toUpperCase() == "TR" )
			{
				return _fnNodeToDataIndex(oSettings, nNode);
			}
			else if ( nNode.nodeName.toUpperCase() == "TD" )
			{
				var iDataIndex = _fnNodeToDataIndex(oSettings, nNode.parentNode);
				var iCorrector = 0;
				for ( var j=0 ; j<oSettings.aoColumns.length ; j++ )
				{
					if ( oSettings.aoColumns[j].bVisible )
					{
						if ( oSettings.aoData[iDataIndex].nTr.getElementsByTagName('td')[j-iCorrector] == nNode )
						{
							return [ iDataIndex, j-iCorrector, j ];
						}
					}
					else
					{
						iCorrector++;
					}
				}
			}
			return null;
		};
		
		/*
		 * Function: fnUpdate
		 * Purpose:  Update a table cell or row
		 * Returns:  int: 0 okay, 1 error
		 * Inputs:   array string 'or' string:mData - data to update the cell/row with
		 *           mixed:mRow - 
		 *             int: - index of aoData to be updated, or
		 *             node(TR): - TR element you want to update
		 *           int:iColumn - the column to update - optional (not used of mData is 2D)
		 *           bool:bRedraw - redraw the table or not - default true
		 *           bool:bAction - perform predraw actions or not (you will want this as 'true' if
		 *             you have bRedraw as true) - default true
		 */
		this.fnUpdate = function( mData, mRow, iColumn, bRedraw, bAction )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			var iVisibleColumn;
			var sDisplay;
			var iRow = (typeof mRow == 'object') ? 
				_fnNodeToDataIndex(oSettings, mRow) : mRow;
			
			if ( typeof mData != 'object' )
			{
				sDisplay = mData;
				oSettings.aoData[iRow]._aData[iColumn] = sDisplay;
				
				if ( oSettings.aoColumns[iColumn].fnRender !== null )
				{
					sDisplay = oSettings.aoColumns[iColumn].fnRender( {
						"iDataRow": iRow,
						"iDataColumn": iColumn,
						"aData": oSettings.aoData[iRow]._aData,
						"oSettings": oSettings
					} );
					
					if ( oSettings.aoColumns[iColumn].bUseRendered )
					{
						oSettings.aoData[iRow]._aData[iColumn] = sDisplay;
					}
				}
				
				iVisibleColumn = _fnColumnIndexToVisible( oSettings, iColumn );
				if ( iVisibleColumn !== null )
				{
					oSettings.aoData[iRow].nTr.getElementsByTagName('td')[iVisibleColumn].innerHTML = 
						sDisplay;
				}
			}
			else
			{
				if ( mData.length != oSettings.aoColumns.length )
				{
					_fnLog( oSettings, 0, 'An array passed to fnUpdate must have the same number of '+
						'columns as the table in question - in this case '+oSettings.aoColumns.length );
					return 1;
				}
				
				for ( var i=0 ; i<mData.length ; i++ )
				{
					sDisplay = mData[i];
					oSettings.aoData[iRow]._aData[i] = sDisplay;
					
					if ( oSettings.aoColumns[i].fnRender !== null )
					{
						sDisplay = oSettings.aoColumns[i].fnRender( {
							"iDataRow": iRow,
							"iDataColumn": i,
							"aData": oSettings.aoData[iRow]._aData,
							"oSettings": oSettings
						} );
						
						if ( oSettings.aoColumns[i].bUseRendered )
						{
							oSettings.aoData[iRow]._aData[i] = sDisplay;
						}
					}
					
					iVisibleColumn = _fnColumnIndexToVisible( oSettings, i );
					if ( iVisibleColumn !== null )
					{
						oSettings.aoData[iRow].nTr.getElementsByTagName('td')[iVisibleColumn].innerHTML = 
							sDisplay;
					}
				}
			}
			
			/* Modify the search index for this row (strictly this is likely not needed, since fnReDraw
			 * will rebuild the search array - however, the redraw might be disabled by the user)
			 */
			var iDisplayIndex = $.inArray( iRow, oSettings.aiDisplay );
			oSettings.asDataSearch[iDisplayIndex] = _fnBuildSearchRow( oSettings, 
				oSettings.aoData[iRow]._aData );
			
			/* Perform pre-draw actions */
			if ( typeof bAction == 'undefined' || bAction )
			{
				_fnAjustColumnSizing( oSettings );
			}
			
			/* Redraw the table */
			if ( typeof bRedraw == 'undefined' || bRedraw )
			{
				_fnReDraw( oSettings );
			}
			return 0;
		};
		
		
		/*
		 * Function: fnShowColoumn
		 * Purpose:  Show a particular column
		 * Returns:  -
		 * Inputs:   int:iCol - the column whose display should be changed
		 *           bool:bShow - show (true) or hide (false) the column
		 *           bool:bRedraw - redraw the table or not - default true
		 */
		this.fnSetColumnVis = function ( iCol, bShow, bRedraw )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			var i, iLen;
			var iColumns = oSettings.aoColumns.length;
			var nTd, anTds, nCell, anTrs, jqChildren;
			
			/* No point in doing anything if we are requesting what is already true */
			if ( oSettings.aoColumns[iCol].bVisible == bShow )
			{
				return;
			}
			
			var nTrHead = $('>tr', oSettings.nTHead)[0];
			var nTrFoot = $('>tr', oSettings.nTFoot)[0];
			var anTheadTh = [];
			var anTfootTh = [];
			for ( i=0 ; i<iColumns ; i++ )
			{
				anTheadTh.push( oSettings.aoColumns[i].nTh );
				anTfootTh.push( oSettings.aoColumns[i].nTf );
			}
			
			/* Show the column */
			if ( bShow )
			{
				var iInsert = 0;
				for ( i=0 ; i<iCol ; i++ )
				{
					if ( oSettings.aoColumns[i].bVisible )
					{
						iInsert++;
					}
				}
				
				/* Need to decide if we should use appendChild or insertBefore */
				if ( iInsert >= _fnVisbleColumns( oSettings ) )
				{
					nTrHead.appendChild( anTheadTh[iCol] );
					anTrs = $('>tr', oSettings.nTHead);
					for ( i=1, iLen=anTrs.length ; i<iLen ; i++ )
					{
						anTrs[i].appendChild( oSettings.aoColumns[iCol].anThExtra[i-1] );
					}	
					
					if ( nTrFoot )
					{
						nTrFoot.appendChild( anTfootTh[iCol] );
						anTrs = $('>tr', oSettings.nTFoot);
						for ( i=1, iLen=anTrs.length ; i<iLen ; i++ )
						{
							anTrs[i].appendChild( oSettings.aoColumns[iCol].anTfExtra[i-1] );
						}	
					}
					
					for ( i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
					{
						nTd = oSettings.aoData[i]._anHidden[iCol];
						oSettings.aoData[i].nTr.appendChild( nTd );
					}
				}
				else
				{
					/* Which coloumn should we be inserting before? */
					var iBefore;
					for ( i=iCol ; i<iColumns ; i++ )
					{
						iBefore = _fnColumnIndexToVisible( oSettings, i );
						if ( iBefore !== null )
						{
							break;
						}
					}
					
					nTrHead.insertBefore( anTheadTh[iCol], nTrHead.getElementsByTagName('th')[iBefore] );
					anTrs = $('>tr', oSettings.nTHead);
					for ( i=1, iLen=anTrs.length ; i<iLen ; i++ )
					{
						jqChildren = $(anTrs[i]).children();
						anTrs[i].insertBefore( oSettings.aoColumns[iCol].anThExtra[i-1], jqChildren[iBefore] );
					}	
					
					if ( nTrFoot )
					{
						nTrFoot.insertBefore( anTfootTh[iCol], nTrFoot.getElementsByTagName('th')[iBefore] );
						anTrs = $('>tr', oSettings.nTFoot);
						for ( i=1, iLen=anTrs.length ; i<iLen ; i++ )
						{
							jqChildren = $(anTrs[i]).children();
							anTrs[i].insertBefore( oSettings.aoColumns[iCol].anTfExtra[i-1], jqChildren[iBefore] );
						}	
					}
					
					anTds = _fnGetTdNodes( oSettings );
					for ( i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
					{
						nTd = oSettings.aoData[i]._anHidden[iCol];
						oSettings.aoData[i].nTr.insertBefore( nTd, $('>td:eq('+iBefore+')', 
							oSettings.aoData[i].nTr)[0] );
					}
				}
				
				oSettings.aoColumns[iCol].bVisible = true;
			}
			else
			{
				/* Remove a column from display */
				nTrHead.removeChild( anTheadTh[iCol] );
				for ( i=0, iLen=oSettings.aoColumns[iCol].anThExtra.length ; i<iLen ; i++ )
				{
					nCell = oSettings.aoColumns[iCol].anThExtra[i];
					nCell.parentNode.removeChild( nCell );
				}
				
				if ( nTrFoot )
				{
					nTrFoot.removeChild( anTfootTh[iCol] );
					for ( i=0, iLen=oSettings.aoColumns[iCol].anTfExtra.length ; i<iLen ; i++ )
					{
						nCell = oSettings.aoColumns[iCol].anTfExtra[i];
						nCell.parentNode.removeChild( nCell );
					}
				}
				
				anTds = _fnGetTdNodes( oSettings );
				for ( i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
				{
					nTd = anTds[ ( i*oSettings.aoColumns.length) + (iCol*1) ];
					oSettings.aoData[i]._anHidden[iCol] = nTd;
					nTd.parentNode.removeChild( nTd );
				}
				
				oSettings.aoColumns[iCol].bVisible = false;
			}
			
			/* If there are any 'open' rows, then we need to alter the colspan for this col change */
			for ( i=0, iLen=oSettings.aoOpenRows.length ; i<iLen ; i++ )
			{
				oSettings.aoOpenRows[i].nTr.colSpan = _fnVisbleColumns( oSettings );
			}
			
			/* Do a redraw incase anything depending on the table columns needs it 
			 * (built-in: scrolling) 
			 */
			if ( typeof bRedraw == 'undefined' || bRedraw )
			{
				_fnAjustColumnSizing( oSettings );
				_fnDraw( oSettings );
			}
			
			_fnSaveState( oSettings );
		};
		
		/*
		 * Function: fnPageChange
		 * Purpose:  Change the pagination
		 * Returns:  -
		 * Inputs:   string:sAction - paging action to take: "first", "previous", "next" or "last"
		 *           bool:bRedraw - redraw the table or not - optional - default true
		 */
		this.fnPageChange = function ( sAction, bRedraw )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			_fnPageChange( oSettings, sAction );
			_fnCalculateEnd( oSettings );
			
			if ( typeof bRedraw == 'undefined' || bRedraw )
			{
				_fnDraw( oSettings );
			}
		};
		
		/*
		 * Function: fnDestroy
		 * Purpose:  Destructor for the DataTable
		 * Returns:  -
		 * Inputs:   -
		 */
		this.fnDestroy = function ( )
		{
			var oSettings = _fnSettingsFromNode( this[_oExt.iApiIndex] );
			var nOrig = oSettings.nTableWrapper.parentNode;
			var nBody = oSettings.nTBody;
			var i, iLen;
			
			/* Flag to note that the table is currently being destoryed - no action should be taken */
			oSettings.bDestroying = true;
			
			/* Restore hidden columns */
			for ( i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
			{
				if ( oSettings.aoColumns[i].bVisible === false )
				{
					this.fnSetColumnVis( i, true );
				}
			}
			
			/* If there is an 'empty' indicator row, remove it */
			$('tbody>tr>td.'+oSettings.oClasses.sRowEmpty, oSettings.nTable).parent().remove();
			
			/* When scrolling we had to break the table up - restore it */
			if ( oSettings.nTable != oSettings.nTHead.parentNode )
			{
				$('>thead', oSettings.nTable).remove();
				oSettings.nTable.appendChild( oSettings.nTHead );
			}
			
			if ( oSettings.nTFoot && oSettings.nTable != oSettings.nTFoot.parentNode )
			{
				$('>tfoot', oSettings.nTable).remove();
				oSettings.nTable.appendChild( oSettings.nTFoot );
			}
			
			/* Remove the DataTables generated nodes, events and classes */
			oSettings.nTable.parentNode.removeChild( oSettings.nTable );
			$(oSettings.nTableWrapper).remove();
			
			oSettings.aaSorting = [];
			oSettings.aaSortingFixed = [];
			_fnSortingClasses( oSettings );
			
			$(_fnGetTrNodes( oSettings )).removeClass( oSettings.asStripClasses.join(' ') );
			
			if ( !oSettings.bJUI )
			{
				$('th', oSettings.nTHead).removeClass( [ _oExt.oStdClasses.sSortable,
					_oExt.oStdClasses.sSortableAsc,
					_oExt.oStdClasses.sSortableDesc,
					_oExt.oStdClasses.sSortableNone ].join(' ')
				);
			}
			else
			{
				$('th', oSettings.nTHead).removeClass( [ _oExt.oStdClasses.sSortable,
					_oExt.oJUIClasses.sSortableAsc,
					_oExt.oJUIClasses.sSortableDesc,
					_oExt.oJUIClasses.sSortableNone ].join(' ')
				);
				$('th span.dt-icon-sort', oSettings.nTHead).remove();
			}
			
			/* Add the TR elements back into the table in their original order */
			nOrig.appendChild( oSettings.nTable );
			for ( i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
			{
				nBody.appendChild( oSettings.aoData[i].nTr );
			}
			
			/* Restore the width of the original table */
			oSettings.nTable.style.width = _fnStringToCss(oSettings.sDestroyWidth);
			
			/* If the were originally odd/even type classes - then we add them back here. Note
			 * this is not fool proof (for example if not all rows as odd/even classes - but 
			 * it's a good effort without getting carried away
			 */
			$('>tr:even', nBody).addClass( oSettings.asDestoryStrips[0] );
			$('>tr:odd', nBody).addClass( oSettings.asDestoryStrips[1] );
			
			/* Remove the settings object from the settings array */
			for ( i=0, iLen=_aoSettings.length ; i<iLen ; i++ )
			{
				if ( _aoSettings[i] == oSettings )
				{
					_aoSettings.splice( i, 1 );
				}
			}
			
			/* End it all */
			oSettings = null;
		};
		
		/*
		 * Function: _fnAjustColumnSizing
		 * Purpose:  Update tale sizing based on content. This would most likely be used for scrolling
		 *   and will typically need a redraw after it.
		 * Returns:  -
		 * Inputs:   bool:bRedraw - redraw the table or not, you will typically want to - default true
		 */
		this.fnAdjustColumnSizing = function ( bRedraw )
		{
			var oSettings = _fnSettingsFromNode(this[_oExt.iApiIndex]);
			_fnAjustColumnSizing( oSettings );
			
			if ( typeof bRedraw == 'undefined' || bRedraw )
			{
				this.fnDraw( false );
			}
			else if ( oSettings.oScroll.sX !== "" || oSettings.oScroll.sY !== "" )
			{
				/* If not redrawing, but scrolling, we want to apply the new column sizes anyway */
				this.oApi._fnScrollDraw(oSettings);
			}
		};
		
		/*
		 * Plugin API functions
		 * 
		 * This call will add the functions which are defined in _oExt.oApi to the
		 * DataTables object, providing a rather nice way to allow plug-in API functions. Note that
		 * this is done here, so that API function can actually override the built in API functions if
		 * required for a particular purpose.
		 */
		
		/*
		 * Function: _fnExternApiFunc
		 * Purpose:  Create a wrapper function for exporting an internal func to an external API func
		 * Returns:  function: - wrapped function
		 * Inputs:   string:sFunc - API function name
		 */
		function _fnExternApiFunc (sFunc)
		{
			return function() {
					var aArgs = [_fnSettingsFromNode(this[_oExt.iApiIndex])].concat( 
						Array.prototype.slice.call(arguments) );
					return _oExt.oApi[sFunc].apply( this, aArgs );
				};
		}
		
		for ( var sFunc in _oExt.oApi )
		{
			if ( sFunc )
			{
				/*
				 * Function: anon
				 * Purpose:  Wrap the plug-in API functions in order to provide the settings as 1st arg 
				 *   and execute in this scope
				 * Returns:  -
				 * Inputs:   -
				 */
				this[sFunc] = _fnExternApiFunc(sFunc);
			}
		}
		
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Local functions
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Initalisation
		 */
		
		/*
		 * Function: _fnInitalise
		 * Purpose:  Draw the table for the first time, adding all required features
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnInitalise ( oSettings )
		{
			var i, iLen;
			
			/* Ensure that the table data is fully initialised */
			if ( oSettings.bInitialised === false )
			{
				setTimeout( function(){ _fnInitalise( oSettings ); }, 200 );
				return;
			}
			
			/* Show the display HTML options */
			_fnAddOptionsHtml( oSettings );
			
			/* Draw the headers for the table */
			_fnDrawHead( oSettings );
			
			/* Okay to show that something is going on now */
			_fnProcessingDisplay( oSettings, true );
			
			/* Calculate sizes for columns */
			if ( oSettings.oFeatures.bAutoWidth )
			{
				_fnCalculateColumnWidths( oSettings );
			}
			
			for ( i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
			{
				if ( oSettings.aoColumns[i].sWidth !== null )
				{
					oSettings.aoColumns[i].nTh.style.width = _fnStringToCss( oSettings.aoColumns[i].sWidth );
				}
			}
			
			/* If there is default sorting required - let's do it. The sort function will do the
			 * drawing for us. Otherwise we draw the table regardless of the Ajax source - this allows
			 * the table to look initialised for Ajax sourcing data (show 'loading' message possibly)
			 */
			if ( oSettings.oFeatures.bSort )
			{
				_fnSort( oSettings );
			}
			else
			{
				oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
				_fnCalculateEnd( oSettings );
				_fnDraw( oSettings );
			}
			
			/* if there is an ajax source load the data */
			if ( oSettings.sAjaxSource !== null && !oSettings.oFeatures.bServerSide )
			{
				oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, [], function(json) {
					/* Got the data - add it to the table */
					for ( i=0 ; i<json.aaData.length ; i++ )
					{
						_fnAddData( oSettings, json.aaData[i] );
					}
					
					/* Reset the init display for cookie saving. We've already done a filter, and
					 * therefore cleared it before. So we need to make it appear 'fresh'
					 */
					oSettings.iInitDisplayStart = oSettings._iDisplayStart;
					
					if ( oSettings.oFeatures.bSort )
					{
						_fnSort( oSettings );
					}
					else
					{
						oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
						_fnCalculateEnd( oSettings );
						_fnDraw( oSettings );
					}
					
					_fnProcessingDisplay( oSettings, false );
					_fnInitComplete( oSettings, json );
				} );
				return;
			}
			
			/* Server-side processing initialisation complete is done at the end of _fnDraw */
			if ( !oSettings.oFeatures.bServerSide )
			{
				_fnProcessingDisplay( oSettings, false );
				_fnInitComplete( oSettings );
			}
		}
		
		/*
		 * Function: _fnInitalise
		 * Purpose:  Draw the table for the first time, adding all required features
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnInitComplete ( oSettings, json )
		{
			oSettings._bInitComplete = true;
			if ( typeof oSettings.fnInitComplete == 'function' )
			{
				if ( typeof json != 'undefined' )
				{
					oSettings.fnInitComplete.call( oSettings.oInstance, oSettings, json );
				}
				else
				{
					oSettings.fnInitComplete.call( oSettings.oInstance, oSettings );
				}
			}
		}
		
		/*
		 * Function: _fnLanguageProcess
		 * Purpose:  Copy language variables from remote object to a local one
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           object:oLanguage - Language information
		 *           bool:bInit - init once complete
		 */
		function _fnLanguageProcess( oSettings, oLanguage, bInit )
		{
			_fnMap( oSettings.oLanguage, oLanguage, 'sProcessing' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sLengthMenu' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sEmptyTable' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sZeroRecords' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sInfo' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sInfoEmpty' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sInfoFiltered' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sInfoPostFix' );
			_fnMap( oSettings.oLanguage, oLanguage, 'sSearch' );
			
			if ( typeof oLanguage.oPaginate != 'undefined' )
			{
				_fnMap( oSettings.oLanguage.oPaginate, oLanguage.oPaginate, 'sFirst' );
				_fnMap( oSettings.oLanguage.oPaginate, oLanguage.oPaginate, 'sPrevious' );
				_fnMap( oSettings.oLanguage.oPaginate, oLanguage.oPaginate, 'sNext' );
				_fnMap( oSettings.oLanguage.oPaginate, oLanguage.oPaginate, 'sLast' );
			}
			
			/* Backwards compatibility - if there is no sEmptyTable given, then use the same as
			 * sZeroRecords - assuming that is given.
			 */
			if ( typeof oLanguage.sEmptyTable == 'undefined' && 
			     typeof oLanguage.sZeroRecords != 'undefined' )
			{
				_fnMap( oSettings.oLanguage, oLanguage, 'sZeroRecords', 'sEmptyTable' );
			}
			
			if ( bInit )
			{
				_fnInitalise( oSettings );
			}
		}
		
		/*
		 * Function: _fnAddColumn
		 * Purpose:  Add a column to the list used for the table with default values
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           node:nTh - the th element for this column
		 */
		function _fnAddColumn( oSettings, nTh )
		{
			var jqTh = jQuery(nTh);
			oSettings.aoColumns[ oSettings.aoColumns.length++ ] = {
				"sType": null,
				"_bAutoType": true,
				"bVisible": true,
				"bSearchable": true,
				"bSortable": true,
				"asSorting": [ 'asc', 'desc' ],
				"sSortingClass": oSettings.oClasses.sSortable,
				"sSortingClassJUI": oSettings.oClasses.sSortJUI,
				"sTitle": nTh ? nTh.innerHTML : '',
				"sName": '',
				"sWidth": null,
				"sWidthOrig": null,
				"sClass": null,
				"fnRender": null,
				"bUseRendered": true,
				"iDataSort": oSettings.aoColumns.length-1,
				"sSortDataType": 'std',
				"nTh": nTh ? nTh : document.createElement('th'),
				"nTf": null,
				"anThExtra": [],
				"anTfExtra": []
			};
			
			var iCol = oSettings.aoColumns.length-1;
			var oCol = oSettings.aoColumns[ iCol ];
			
			/* Add a column specific filter */
			if ( typeof oSettings.aoPreSearchCols[ iCol ] == 'undefined' ||
			     oSettings.aoPreSearchCols[ iCol ] === null )
			{
				oSettings.aoPreSearchCols[ iCol ] = {
					"sSearch": "",
					"bRegex": false,
					"bSmart": true
				};
			}
			else
			{
				/* Don't require that the user must specify bRegex and / or bSmart */
				if ( typeof oSettings.aoPreSearchCols[ iCol ].bRegex == 'undefined' )
				{
					oSettings.aoPreSearchCols[ iCol ].bRegex = true;
				}
				
				if ( typeof oSettings.aoPreSearchCols[ iCol ].bSmart == 'undefined' )
				{
					oSettings.aoPreSearchCols[ iCol ].bSmart = true;
				}
			} 
			
			/* Use the column options function to initialise classes etc */
			_fnColumnOptions( oSettings, iCol, null);
		}
		
		/*
		 * Function: _fnColumnOptions
		 * Purpose:  Apply options for a column
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           int:iCol - column index to consider
		 *           object:oOptions - object with sType, bVisible and bSearchable
		 */
		function _fnColumnOptions( oSettings, iCol, oOptions )
		{
			var oCol = oSettings.aoColumns[ iCol ];
			
			/* User specified column options */
			if ( typeof oOptions != 'undefined' && oOptions !== null )
			{
				if ( typeof oOptions.sType != 'undefined' )
				{
					oCol.sType = oOptions.sType;
					oCol._bAutoType = false;
				}
				_fnMap( oCol, oOptions, "bVisible" );
				_fnMap( oCol, oOptions, "bSearchable" );
				_fnMap( oCol, oOptions, "bSortable" );
				_fnMap( oCol, oOptions, "sTitle" );
				_fnMap( oCol, oOptions, "sName" );
				_fnMap( oCol, oOptions, "sWidth" );
				_fnMap( oCol, oOptions, "sWidth", "sWidthOrig" );
				_fnMap( oCol, oOptions, "sClass" );
				_fnMap( oCol, oOptions, "fnRender" );
				_fnMap( oCol, oOptions, "bUseRendered" );
				_fnMap( oCol, oOptions, "iDataSort" );
				_fnMap( oCol, oOptions, "asSorting" );
				_fnMap( oCol, oOptions, "sSortDataType" );
			}
			
			var jqTh = jQuery(oCol.nTh);
			/* Feature sorting overrides column specific when off */
			if ( !oSettings.oFeatures.bSort ){
				oCol.bSortable = false;
			}else{
				oCol.bSortable = !jqTh.hasClass("column-unsortable");
			}
			oCol.bVisible = !jqTh.hasClass("column-hidden");
			
			/* Check that the class assignment is correct for sorting */
			
			if(jqTh.hasClass("column-sorted") || jqTh.hasClass("column-sorted-asc")){
				oCol.sSortingClass = oSettings.oClasses.sSortableAsc;
				oCol.sSortingClassJUI = oSettings.oClasses.sSortJUIAscAllowed;
			}
			else if(jqTh.hasClass("column-sorted-desc")){
				oCol.sSortingClass = oSettings.oClasses.sSortableDesc;
				oCol.sSortingClassJUI = oSettings.oClasses.sSortJUIDescAllowed;
			}
			else if ( !oCol.bSortable ||
					 ($.inArray('asc', oCol.asSorting) == -1 && $.inArray('desc', oCol.asSorting) == -1) )
			{
				oCol.sSortingClass = oSettings.oClasses.sSortableNone;
				oCol.sSortingClassJUI = "";
			}
			else if ( $.inArray('asc', oCol.asSorting) != -1 && $.inArray('desc', oCol.asSorting) == -1 )
			{
				oCol.sSortingClass = oSettings.oClasses.sSortableAsc;
				oCol.sSortingClassJUI = oSettings.oClasses.sSortJUIAscAllowed;
			}
			else if ( $.inArray('asc', oCol.asSorting) == -1 && $.inArray('desc', oCol.asSorting) != -1 )
			{
				oCol.sSortingClass = oSettings.oClasses.sSortableDesc;
				oCol.sSortingClassJUI = oSettings.oClasses.sSortJUIDescAllowed;
			}
			
			if(jqTh.hasClass("date")){
				oCol.sSortDataType = "date";
			}

			oCol.bSearchable = !jqTh.hasClass("column-non-searchable");

		}
		
		/*
		 * Function: _fnAddData
		 * Purpose:  Add a data array to the table, creating DOM node etc
		 * Returns:  int: - >=0 if successful (index of new aoData entry), -1 if failed
		 * Inputs:   object:oSettings - dataTables settings object
		 *           array:aData - data array to be added
		 * Notes:    There are two basic methods for DataTables to get data to display - a JS array
		 *   (which is dealt with by this function), and the DOM, which has it's own optimised
		 *   function (_fnGatherData). Be careful to make the same changes here as there and vice-versa
		 */
		function _fnAddData ( oSettings, aDataSupplied )
		{
			/* Sanity check the length of the new array */
			if ( aDataSupplied.length != oSettings.aoColumns.length &&
				oSettings.iDrawError != oSettings.iDraw )
			{
				_fnLog( oSettings, 0, "Added data (size "+aDataSupplied.length+") does not match known "+
					"number of columns ("+oSettings.aoColumns.length+")" );
				oSettings.iDrawError = oSettings.iDraw;
				return -1;
			}
			
			
			/* Create the object for storing information about this new row */
			var aData = aDataSupplied.slice();
			var iThisIndex = oSettings.aoData.length;
			oSettings.aoData.push( {
				"nTr": document.createElement('tr'),
				"_iId": oSettings.iNextId++,
				"_aData": aData,
				"_anHidden": [],
				"_sRowStripe": ''
			} );
			
			/* Create the cells */
			var nTd, sThisType;
			for ( var i=0 ; i<aData.length ; i++ )
			{
				nTd = document.createElement('td');
				
				/* Allow null data (from a data array) - simply deal with it as a blank string */
				if ( aData[i] === null )
				{
					aData[i] = '';
				}
				
				if ( typeof oSettings.aoColumns[i].fnRender == 'function' )
				{
					var sRendered = oSettings.aoColumns[i].fnRender( {
							"iDataRow": iThisIndex,
							"iDataColumn": i,
							"aData": aData,
							"oSettings": oSettings
						} );
					nTd.innerHTML = sRendered;
					if ( oSettings.aoColumns[i].bUseRendered )
					{
						/* Use the rendered data for filtering/sorting */
						oSettings.aoData[iThisIndex]._aData[i] = sRendered;
					}
				}
				else
				{
					nTd.innerHTML = aData[i];
				}
				
				/* Cast everything as a string - so we can treat everything equally when sorting */
				if ( typeof aData[i] != 'string' )
				{
					aData[i] += "";
				}
				aData[i] = $.trim(aData[i]);
				
				/* Add user defined class */
				if ( oSettings.aoColumns[i].sClass !== null )
				{
					nTd.className = oSettings.aoColumns[i].sClass;
				}
				
				/* See if we should auto-detect the column type */
				if ( oSettings.aoColumns[i]._bAutoType && oSettings.aoColumns[i].sType != 'string' )
				{
					/* Attempt to auto detect the type - same as _fnGatherData() */
					sThisType = _fnDetectType( oSettings.aoData[iThisIndex]._aData[i] );
					if ( oSettings.aoColumns[i].sType === null )
					{
						oSettings.aoColumns[i].sType = sThisType;
					}
					else if ( oSettings.aoColumns[i].sType != sThisType )
					{
						/* String is always the 'fallback' option */
						oSettings.aoColumns[i].sType = 'string';
					}
				}
					
				if ( oSettings.aoColumns[i].bVisible )
				{
					oSettings.aoData[iThisIndex].nTr.appendChild( nTd );
					oSettings.aoData[iThisIndex]._anHidden[i] = null;
				}
				else
				{
					oSettings.aoData[iThisIndex]._anHidden[i] = nTd;
				}
			}
			
			/* Add to the display array */
			oSettings.aiDisplayMaster.push( iThisIndex );
			return iThisIndex;
		}
		
		/*
		 * Function: _fnGatherData
		 * Purpose:  Read in the data from the target table from the DOM
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 * Notes:    This is a optimised version of _fnAddData (more or less) for reading information
		 *   from the DOM. The basic actions must be identical in the two functions.
		 */
		function _fnGatherData( oSettings )
		{
			var iLoop, i, iLen, j, jLen, jInner,
			 	nTds, nTrs, nTd, aLocalData, iThisIndex,
				iRow, iRows, iColumn, iColumns;
			
			/*
			 * Process by row first
			 * Add the data object for the whole table - storing the tr node. Note - no point in getting
			 * DOM based data if we are going to go and replace it with Ajax source data.
			 */
			if ( oSettings.sAjaxSource === null )
			{
				nTrs = oSettings.nTBody.childNodes;
				for ( i=0, iLen=nTrs.length ; i<iLen ; i++ )
				{
					if ( nTrs[i].nodeName.toUpperCase() == "TR" )
					{
						iThisIndex = oSettings.aoData.length;
						oSettings.aoData.push( {
							"nTr": nTrs[i],
							"_iId": oSettings.iNextId++,
							"_aData": [],
							"_anHidden": [],
							"_sRowStripe": ''
						} );
						
						oSettings.aiDisplayMaster.push( iThisIndex );
						
						aLocalData = oSettings.aoData[iThisIndex]._aData;
						nTds = nTrs[i].childNodes;
						jInner = 0;
						
						for ( j=0, jLen=nTds.length ; j<jLen ; j++ )
						{
							if ( nTds[j].nodeName.toUpperCase() == "TD" )
							{
								aLocalData[jInner] = $.trim(nTds[j].innerHTML);
								jInner++;
							}
						}
					}
				}
			}
			
			/* Gather in the TD elements of the Table - note that this is basically the same as
			 * fnGetTdNodes, but that function takes account of hidden columns, which we haven't yet
			 * setup!
			 */
			nTrs = _fnGetTrNodes( oSettings );
			nTds = [];
			for ( i=0, iLen=nTrs.length ; i<iLen ; i++ )
			{
				for ( j=0, jLen=nTrs[i].childNodes.length ; j<jLen ; j++ )
				{
					nTd = nTrs[i].childNodes[j];
					if ( nTd.nodeName.toUpperCase() == "TD" )
					{
						nTds.push( nTd );
					}
				}
			}
			
			/* Sanity check */
			if ( nTds.length != nTrs.length * oSettings.aoColumns.length )
			{
				_fnLog( oSettings, 1, "Unexpected number of TD elements. Expected "+
					(nTrs.length * oSettings.g.length)+" and got "+nTds.length+". DataTables does "+
					"not support rowspan / colspan in the table body, and there must be one cell for each "+
					"row/column combination." );
			}
			
			/* Now process by column */
			for ( iColumn=0, iColumns=oSettings.aoColumns.length ; iColumn<iColumns ; iColumn++ )
			{
				/* Get the title of the column - unless there is a user set one */
				if ( oSettings.aoColumns[iColumn].sTitle === null )
				{
					oSettings.aoColumns[iColumn].sTitle = oSettings.aoColumns[iColumn].nTh.innerHTML;
				}
				
				var
					bAutoType = oSettings.aoColumns[iColumn]._bAutoType,
					bRender = typeof oSettings.aoColumns[iColumn].fnRender == 'function',
					bClass = oSettings.aoColumns[iColumn].sClass !== null,
					bVisible = oSettings.aoColumns[iColumn].bVisible,
					nCell, sThisType, sRendered;
				
				/* A single loop to rule them all (and be more efficient) */
				if ( bAutoType || bRender || bClass || !bVisible )
				{
					for ( iRow=0, iRows=oSettings.aoData.length ; iRow<iRows ; iRow++ )
					{
						nCell = nTds[ (iRow*iColumns) + iColumn ];
						
						/* Type detection */
						if ( bAutoType )
						{
							if ( oSettings.aoColumns[iColumn].sType != 'string' )
							{
								sThisType = _fnDetectType( oSettings.aoData[iRow]._aData[iColumn] );
								if ( oSettings.aoColumns[iColumn].sType === null )
								{
									oSettings.aoColumns[iColumn].sType = sThisType;
								}
								else if ( oSettings.aoColumns[iColumn].sType != sThisType )
								{
									/* String is always the 'fallback' option */
									oSettings.aoColumns[iColumn].sType = 'string';
								}
							}
						}
						
						/* Rendering */
						if ( bRender )
						{
							sRendered = oSettings.aoColumns[iColumn].fnRender( {
									"iDataRow": iRow,
									"iDataColumn": iColumn,
									"aData": oSettings.aoData[iRow]._aData,
									"oSettings": oSettings
								} );
							nCell.innerHTML = sRendered;
							if ( oSettings.aoColumns[iColumn].bUseRendered )
							{
								/* Use the rendered data for filtering/sorting */
								oSettings.aoData[iRow]._aData[iColumn] = sRendered;
							}
						}
						
						/* Classes */
						if ( bClass )
						{
							nCell.className += ' '+oSettings.aoColumns[iColumn].sClass;
						}
						
						/* Column visability */
						if ( !bVisible )
						{
							oSettings.aoData[iRow]._anHidden[iColumn] = nCell;
							nCell.parentNode.removeChild( nCell );
						}
						else
						{
							oSettings.aoData[iRow]._anHidden[iColumn] = null;
						}
					}
				}
			}
		}
		
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Drawing functions
		 */
		
		/*
		 * Function: _fnDrawHead
		 * Purpose:  Create the HTML header for the table
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnDrawHead( oSettings )
		{
			var i, nTh, iLen, j, jLen;
			var anTr = oSettings.nTHead.getElementsByTagName('tr');
			var iThs = oSettings.nTHead.getElementsByTagName('th').length;
			var iCorrector = 0;
			var jqChildren;
			
			/* If there is a header in place - then use it - otherwise it's going to get nuked... */
			if ( iThs !== 0 )
			{
				/* We've got a thead from the DOM, so remove hidden columns and apply width to vis cols */
				for ( i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
				{
					nTh = oSettings.aoColumns[i].nTh;
					
					if ( oSettings.aoColumns[i].sClass !== null )
					{
						$(nTh).addClass( oSettings.aoColumns[i].sClass );
					}
					
					/* Cache and remove (if needed) any extra elements for this column in the header */
					for ( j=1, jLen=anTr.length ; j<jLen ; j++ )
					{
						jqChildren = $(anTr[j]).children();
						oSettings.aoColumns[i].anThExtra.push( jqChildren[i-iCorrector] );
						if ( !oSettings.aoColumns[i].bVisible )
						{
							anTr[j].removeChild( jqChildren[i-iCorrector] );
						}
					}
					
					if ( oSettings.aoColumns[i].bVisible )
					{
						/* Set the title of the column if it is user defined (not what was auto detected) */
						if ( oSettings.aoColumns[i].sTitle != nTh.innerHTML ){
							nTh.innerHTML = oSettings.aoColumns[i].sTitle;
						}
					}
					else
					{
						nTh.parentNode.removeChild( nTh );
						iCorrector++;
					}
				}
			}
			else
			{
				/* We don't have a header in the DOM - so we are going to have to create one */
				var nTr = document.createElement( "tr" );
				
				for ( i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
				{
					nTh = oSettings.aoColumns[i].nTh;
					nTh.innerHTML = oSettings.aoColumns[i].sTitle;
					
					if ( oSettings.aoColumns[i].sClass !== null )
					{
						$(nTh).addClass( oSettings.aoColumns[i].sClass );
					}
					
					if ( oSettings.aoColumns[i].bVisible )
					{
						nTr.appendChild( nTh );
					}
				}
				$(oSettings.nTHead).html( '' )[0].appendChild( nTr );
			}
			
			/* Add the extra markup needed by jQuery UI's themes */
			if ( oSettings.bJUI )
			{
				for ( i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
				{
					nTh = oSettings.aoColumns[i].nTh;
					
					var nDiv = document.createElement('div');
					nDiv.className = oSettings.oClasses.sSortJUIWrapper;
					$(nTh).contents().appendTo(nDiv);
					var nSortingSpan =document.createElement('span');
					nSortingSpan.className = "dt-icon-sort";
					nDiv.appendChild( nSortingSpan);
					
					nTh.appendChild( nDiv );
					if($(nTh).hasClass("column-select-filter")){
              oSettings.oApi.fnAddColumnSelectFilter(oSettings,i)
           }
				}
			}
			
			/* Add sort listener */
			var fnNoSelect = function (e) {
				this.onselectstart = function() { return false; };
				return true;
			};
			
			if ( oSettings.oFeatures.bSort )
			{
				for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
				{
					if ( oSettings.aoColumns[i].bSortable !== false )
					{
						_fnSortAttachListener( oSettings, oSettings.aoColumns[i].nTh, i );
						
						/* Take the brutal approach to cancelling text selection in header */
						$(oSettings.aoColumns[i].nTh).mousedown( fnNoSelect );
					}
					else
					{
						$(oSettings.aoColumns[i].nTh).addClass( oSettings.oClasses.sSortableNone );
					}
				}
			}
			
			/* Cache the footer elements */
			if ( oSettings.nTFoot !== null )
			{
				iCorrector = 0;
				anTr = oSettings.nTFoot.getElementsByTagName('tr');
				var nTfs = anTr[0].getElementsByTagName('th');
				
				for ( i=0, iLen=nTfs.length ; i<iLen ; i++ )
				{
					if ( typeof oSettings.aoColumns[i] != 'undefined' )
					{
						oSettings.aoColumns[i].nTf = nTfs[i-iCorrector];
						
						if ( oSettings.oClasses.sFooterTH !== "" )
						{
							oSettings.aoColumns[i].nTf.className += " "+oSettings.oClasses.sFooterTH;
						}
						
						/* Deal with any extra elements for this column from the footer */
						for ( j=1, jLen=anTr.length ; j<jLen ; j++ )
						{
							jqChildren = $(anTr[j]).children();
							oSettings.aoColumns[i].anTfExtra.push( jqChildren[i-iCorrector] );
							if ( !oSettings.aoColumns[i].bVisible )
							{
								anTr[j].removeChild( jqChildren[i-iCorrector] );
							}
						}
						
						if ( !oSettings.aoColumns[i].bVisible )
						{
							nTfs[i-iCorrector].parentNode.removeChild( nTfs[i-iCorrector] );
							iCorrector++;
						}
					}
				}
			}
		}
		
		/*
		 * Function: _fnDraw
		 * Purpose:  Insert the required TR nodes into the table for display
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnDraw( oSettings )
		{
			var i, iLen;
			var anRows = [];
			var iRowCount = 0;
			var bRowError = false;
			var iStrips = oSettings.asStripClasses.length;
			var iOpenRows = oSettings.aoOpenRows.length;
			
			oSettings.bDrawing = true;
			
			/* Check and see if we have an initial draw position from state saving */
			if ( typeof oSettings.iInitDisplayStart != 'undefined' && oSettings.iInitDisplayStart != -1 )
			{
				if ( oSettings.oFeatures.bServerSide )
				{
					oSettings._iDisplayStart = oSettings.iInitDisplayStart;
				}
				else
				{
					oSettings._iDisplayStart = (oSettings.iInitDisplayStart >= oSettings.fnRecordsDisplay()) ?
						0 : oSettings.iInitDisplayStart;
				}
				oSettings.iInitDisplayStart = -1;
				_fnCalculateEnd( oSettings );
			}
			
			/* If we are dealing with Ajax - do it here */
			if ( !oSettings.bDestroying && oSettings.oFeatures.bServerSide && 
			     !_fnAjaxUpdate( oSettings ) )
			{
				return;
			}
			else if ( !oSettings.oFeatures.bServerSide )
			{
				oSettings.iDraw++;
			}
			
			if ( oSettings.aiDisplay.length !== 0 )
			{
				var iStart = oSettings._iDisplayStart;
				var iEnd = oSettings._iDisplayEnd;
				
				if ( oSettings.oFeatures.bServerSide )
				{
					iStart = 0;
					iEnd = oSettings.aoData.length;
				}
				
				for ( var j=iStart ; j<iEnd ; j++ )
				{
					var aoData = oSettings.aoData[ oSettings.aiDisplay[j] ];
					var nRow = aoData.nTr;
					
					/* Remove the old stripping classes and then add the new one */
					if ( iStrips !== 0 )
					{
						var sStrip = oSettings.asStripClasses[ iRowCount % iStrips ];
						if ( aoData._sRowStripe != sStrip )
						{
							$(nRow).removeClass( aoData._sRowStripe ).addClass( sStrip );
							aoData._sRowStripe = sStrip;
						}
					}
					
					/* Custom row callback function - might want to manipule the row */
					if ( typeof oSettings.fnRowCallback == "function" )
					{
						nRow = oSettings.fnRowCallback.call( oSettings.oInstance, nRow, 
							oSettings.aoData[ oSettings.aiDisplay[j] ]._aData, iRowCount, j );
						$("td",nRow).each(function(idx){
							oSettings.aoData[ oSettings.aiDisplay[j] ]._aData[idx] = this.innerHTML;
						})
						
						if ( !nRow && !bRowError )
						{
							_fnLog( oSettings, 0, "A node was not returned by fnRowCallback" );
							bRowError = true;
						}
					}
					
					anRows.push( nRow );
					iRowCount++;
					
					/* If there is an open row - and it is attached to this parent - attach it on redraw */
					if ( iOpenRows !== 0 )
					{
						for ( var k=0 ; k<iOpenRows ; k++ )
						{
							if ( nRow == oSettings.aoOpenRows[k].nParent )
							{
								anRows.push( oSettings.aoOpenRows[k].nTr );
							}
						}
					}
				}
			}
			else
			{
				/* Table is empty - create a row with an empty message in it */
				anRows[ 0 ] = document.createElement( 'tr' );
				
				if ( typeof oSettings.asStripClasses[0] != 'undefined' )
				{
					anRows[ 0 ].className = oSettings.asStripClasses[0];
				}
				
				var nTd = document.createElement( 'td' );
				nTd.setAttribute( 'valign', "top" );
				nTd.colSpan = _fnVisbleColumns( oSettings );
				nTd.className = oSettings.oClasses.sRowEmpty;
				if ( typeof oSettings.oLanguage.sEmptyTable != 'undefined' &&
				     oSettings.fnRecordsTotal() === 0 )
				{
					nTd.innerHTML = oSettings.oLanguage.sEmptyTable;
				}
				else
				{
					nTd.innerHTML = oSettings.oLanguage.sZeroRecords.replace(
						'_MAX_', oSettings.fnFormatNumber(oSettings.fnRecordsTotal()) );
				}
				
				anRows[ iRowCount ].appendChild( nTd );
			}
			
			/* Callback the header and footer custom funcation if there is one */
			if ( typeof oSettings.fnHeaderCallback == 'function' )
			{
				oSettings.fnHeaderCallback.call( oSettings.oInstance, $('>tr', oSettings.nTHead)[0], 
					_fnGetDataMaster( oSettings ), oSettings._iDisplayStart, oSettings.fnDisplayEnd(),
					oSettings.aiDisplay );
			}
			
			if ( typeof oSettings.fnFooterCallback == 'function' )
			{
				oSettings.fnFooterCallback.call( oSettings.oInstance, $('>tr', oSettings.nTFoot)[0], 
					_fnGetDataMaster( oSettings ), oSettings._iDisplayStart, oSettings.fnDisplayEnd(),
					oSettings.aiDisplay );
			}
			
			/* 
			 * Need to remove any old row from the display - note we can't just empty the tbody using
			 * $().html('') since this will unbind the jQuery event handlers (even although the node 
			 * still exists!) - equally we can't use innerHTML, since IE throws an exception.
			 */
			var
				nAddFrag = document.createDocumentFragment(),
				nRemoveFrag = document.createDocumentFragment(),
				nBodyPar, nTrs;
			
			if ( oSettings.nTBody )
			{
				nBodyPar = oSettings.nTBody.parentNode;
				nRemoveFrag.appendChild( oSettings.nTBody );
				
				/* When doing infinite scrolling, only remove child rows when sorting, filtering or start
				 * up. When not infinite scroll, always do it.
				 */
				if ( !oSettings.oScroll.bInfinite || !oSettings._bInitComplete ||
				 	oSettings.bSorted || oSettings.bFiltered )
				{
					nTrs = oSettings.nTBody.childNodes;
					for ( i=nTrs.length-1 ; i>=0 ; i-- )
					{
						nTrs[i].parentNode.removeChild( nTrs[i] );
					}
				}
				
				/* Put the draw table into the dom */
				for ( i=0, iLen=anRows.length ; i<iLen ; i++ )
				{
					nAddFrag.appendChild( anRows[i] );
				}
				
				oSettings.nTBody.appendChild( nAddFrag );
				if ( nBodyPar !== null )
				{
					nBodyPar.appendChild( oSettings.nTBody );
				}
			}
			
			/* Call all required callback functions for the end of a draw */
			for ( i=oSettings.aoDrawCallback.length-1 ; i>=0 ; i-- )
			{
				oSettings.aoDrawCallback[i].fn.call( oSettings.oInstance, oSettings );
			}
			
			/* Draw is complete, sorting and filtering must be as well */
			oSettings.bSorted = false;
			oSettings.bFiltered = false;
			oSettings.bDrawing = false;
			
			if ( oSettings.oFeatures.bServerSide )
			{
				_fnProcessingDisplay( oSettings, false );
				if ( typeof oSettings._bInitComplete == 'undefined' )
				{
					_fnInitComplete( oSettings );
				}
			}
		}
		
		/*
		 * Function: _fnReDraw
		 * Purpose:  Redraw the table - taking account of the various features which are enabled
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnReDraw( oSettings )
		{
			if ( oSettings.oFeatures.bSort )
			{
				/* Sorting will refilter and draw for us */
				_fnSort( oSettings, oSettings.oPreviousSearch );
			}
			else if ( oSettings.oFeatures.bFilter )
			{
				/* Filtering will redraw for us */
				_fnFilterComplete( oSettings, oSettings.oPreviousSearch );
			}
			else
			{
				_fnCalculateEnd( oSettings );
				_fnDraw( oSettings );
			}
		}
		
		/*
		 * Function: _fnAjaxUpdate
		 * Purpose:  Update the table using an Ajax call
		 * Returns:  bool: block the table drawing or not
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnAjaxUpdate( oSettings )
		{
			if ( oSettings.bAjaxDataGet )
			{
				_fnProcessingDisplay( oSettings, true );
				var iColumns = oSettings.aoColumns.length;
				var aoData = [];
				var i;
				
				/* Paging and general */
				oSettings.iDraw++;
				aoData.push( { "name": "sEcho",          "value": oSettings.iDraw } );
				aoData.push( { "name": "iColumns",       "value": iColumns } );
				aoData.push( { "name": "sColumns",       "value": _fnColumnOrdering(oSettings) } );
				aoData.push( { "name": "iDisplayStart",  "value": oSettings._iDisplayStart } );
				aoData.push( { "name": "iDisplayLength", "value": oSettings.oFeatures.bPaginate !== false ?
					oSettings._iDisplayLength : -1 } );
				
				/* Filtering */
				if ( oSettings.oFeatures.bFilter !== false )
				{
					aoData.push( { "name": "sSearch", "value": oSettings.oPreviousSearch.sSearch } );
					aoData.push( { "name": "bRegex",  "value": oSettings.oPreviousSearch.bRegex } );
					for ( i=0 ; i<iColumns ; i++ )
					{
						aoData.push( { "name": "sSearch_"+i,     "value": oSettings.aoPreSearchCols[i].sSearch } );
						aoData.push( { "name": "bRegex_"+i,      "value": oSettings.aoPreSearchCols[i].bRegex } );
						aoData.push( { "name": "bSearchable_"+i, "value": oSettings.aoColumns[i].bSearchable } );
					}
				}
				
				/* Sorting */
				if ( oSettings.oFeatures.bSort !== false )
				{
					var iFixed = oSettings.aaSortingFixed !== null ? oSettings.aaSortingFixed.length : 0;
					var iUser = oSettings.aaSorting.length;
					aoData.push( { "name": "iSortingCols",   "value": iFixed+iUser } );
					for ( i=0 ; i<iFixed ; i++ )
					{
						aoData.push( { "name": "iSortCol_"+i,  "value": oSettings.aaSortingFixed[i][0] } );
						aoData.push( { "name": "sSortDir_"+i,  "value": oSettings.aaSortingFixed[i][1] } );
					}
					
					for ( i=0 ; i<iUser ; i++ )
					{
						aoData.push( { "name": "iSortCol_"+(i+iFixed),  "value": oSettings.aaSorting[i][0] } );
						aoData.push( { "name": "sSortDir_"+(i+iFixed),  "value": oSettings.aaSorting[i][1] } );
					}
					
					for ( i=0 ; i<iColumns ; i++ )
					{
						aoData.push( { "name": "bSortable_"+i,  "value": oSettings.aoColumns[i].bSortable } );
					}
				}
				
				oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aoData,
					function(json) {
						_fnAjaxUpdateDraw( oSettings, json );
					} );
				return false;
			}
			else
			{
				return true;
			}
		}
		
		/*
		 * Function: _fnAjaxUpdateDraw
		 * Purpose:  Data the data from the server (nuking the old) and redraw the table
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           object:json - json data return from the server.
		 *             The following must be defined:
		 *               iTotalRecords, iTotalDisplayRecords, aaData
		 *             The following may be defined:
		 *               sColumns
		 */
		function _fnAjaxUpdateDraw ( oSettings, json )
		{
			if ( typeof json.sEcho != 'undefined' )
			{
				/* Protect against old returns over-writing a new one. Possible when you get
				 * very fast interaction, and later queires are completed much faster
				 */
				if ( json.sEcho*1 < oSettings.iDraw )
				{
					return;
				}
				else
				{
					oSettings.iDraw = json.sEcho * 1;
				}
			}
			
			if ( !oSettings.oScroll.bInfinite ||
				   (oSettings.oScroll.bInfinite && (oSettings.bSorted || oSettings.bFiltered)) )
			{
				_fnClearTable( oSettings );
			}
			oSettings._iRecordsTotal = json.iTotalRecords;
			oSettings._iRecordsDisplay = json.iTotalDisplayRecords;
			
			/* Determine if reordering is required */
			var sOrdering = _fnColumnOrdering(oSettings);
			var bReOrder = (typeof json.sColumns != 'undefined' && sOrdering !== "" && json.sColumns != sOrdering );
			if ( bReOrder )
			{
				var aiIndex = _fnReOrderIndex( oSettings, json.sColumns );
			}
			
			for ( var i=0, iLen=json.aaData.length ; i<iLen ; i++ )
			{
				if ( bReOrder )
				{
					/* If we need to re-order, then create a new array with the correct order and add it */
					var aData = [];
					for ( var j=0, jLen=oSettings.aoColumns.length ; j<jLen ; j++ )
					{
						aData.push( json.aaData[i][ aiIndex[j] ] );
					}
					_fnAddData( oSettings, aData );
				}
				else
				{
					/* No re-order required, sever got it "right" - just straight add */
					_fnAddData( oSettings, json.aaData[i] );
				}
			}
			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			
			oSettings.bAjaxDataGet = false;
			_fnDraw( oSettings );
			oSettings.bAjaxDataGet = true;
			_fnProcessingDisplay( oSettings, false );
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Options (features) HTML
		 */
		
		/*
		 * Function: _fnAddOptionsHtml
		 * Purpose:  Add the options to the page HTML for the table
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnAddOptionsHtml ( oSettings )
		{
			/*
			 * Create a temporary, empty, div which we can later on replace with what we have generated
			 * we do it this way to rendering the 'options' html offline - speed :-)
			 */
			var nHolding = document.createElement( 'div' );
			oSettings.nTable.parentNode.insertBefore( nHolding, oSettings.nTable );
			
			/* 
			 * All DataTables are wrapped in a div - this is not currently optional - backwards 
			 * compatability. It can be removed if you don't want it.
			 */
			oSettings.nTableWrapper = document.createElement( 'div' );
			var sClassColumn =   " wrapper-table-"+((oSettings.aoColumns.length < 5)? oSettings.aoColumns.length : "multi")+"-column";
			oSettings.nTableWrapper.className = oSettings.oClasses.sWrapper + sClassColumn;;
			if ( oSettings.sTableId !== '' )
			{
				oSettings.nTableWrapper.setAttribute( 'id', oSettings.sTableId+'_wrapper' );
			}
			
			/* Track where we want to insert the option */
			var nInsertNode = oSettings.nTableWrapper;
			
			/* Loop over the user set positioning and place the elements as needed */
			
			var aDom = oSettings.sDom.split('');
			var nTmp, iPushFeature, cOption, nNewNode, cNext, sAttr, j;
			for ( var i=0 ; i<aDom.length ; i++ )
			{
				iPushFeature = 0;
				cOption = aDom[i];
				if ( cOption == '<' )
				{
					/* New container div */
					nNewNode = document.createElement( 'div' );
					
					/* Check to see if we should append an id and/or a class name to the container */
					cNext = aDom[i+1];
					if ( cNext == "'" || cNext == '"' )
					{
						sAttr = "";
						j = 2;
						while ( aDom[i+j] != cNext )
						{
							sAttr += aDom[i+j];
							j++;
						}
						
						/* Replace jQuery UI constants */
						if ( sAttr == "H" )
						{
							sAttr = "fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix";
						}
						else if ( sAttr == "F" )
						{
							sAttr = "fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix";
						}
						
						/* The attribute can be in the format of "#id.class", "#id" or "class" This logic
						 * breaks the string into parts and applies them as needed
						 */
						if ( sAttr.indexOf('.') != -1 )
						{
							var aSplit = sAttr.split('.');
							nNewNode.setAttribute('id', aSplit[0].substr(1, aSplit[0].length-1) );
							nNewNode.className = aSplit[1];
						}
						else if ( sAttr.charAt(0) == "#" )
						{
							nNewNode.setAttribute('id', sAttr.substr(1, sAttr.length-1) );
						}
						else
						{
							nNewNode.className = sAttr;
						}
						
						i += j; /* Move along the position array */
					}
					
					nInsertNode.appendChild( nNewNode );
					nInsertNode = nNewNode;
				}
				else if ( cOption == '>' )
				{
					/* End container div */
					nInsertNode = nInsertNode.parentNode;
				}
				else if ( cOption == 'l' && oSettings.oFeatures.bPaginate && oSettings.oFeatures.bLengthChange )
				{
					/* Length */
					nTmp = _fnFeatureHtmlLength( oSettings );
					iPushFeature = 1;
				}
				else if ( cOption == 'f' && oSettings.oFeatures.bFilter )
				{
					/* Filter */
					nTmp = _fnFeatureHtmlFilter( oSettings );
					iPushFeature = 1;
				}
				else if ( cOption == 'r' && oSettings.oFeatures.bProcessing )
				{
					/* pRocessing */
					nTmp = _fnFeatureHtmlProcessing( oSettings );
					iPushFeature = 1;
				}
				else if ( cOption == 't' )
				{
					/* Table */
					nTmp = _fnFeatureHtmlTable( oSettings );
					iPushFeature = 1;
				}
				else if ( cOption ==  'i' && oSettings.oFeatures.bInfo )
				{
					/* Info */
					nTmp = _fnFeatureHtmlInfo( oSettings );
					iPushFeature = 1;
				}
				else if ( cOption == 'p' && oSettings.oFeatures.bPaginate )
				{
					/* Pagination */
					nTmp = _fnFeatureHtmlPaginate( oSettings );
					iPushFeature = 1;
				}
				else if(cOption == "G" && $(oSettings.nTable).hasClass("dt-graphicable")){
					nTmp = document.createElement('div')
					nTmp.className = "DT_graphic_toolbar";
					nTmp.innerHTML = "<span class='ui-icon inline-icon nuvola-icon ui-nuvola-chart-1 clickable DT-chart-button'></span>";
					iPushFeature = 1;
				}
				else if ( _oExt.aoFeatures.length !== 0 )
				{
					/* Plug-in features */
					var aoFeatures = _oExt.aoFeatures;
					for ( var k=0, kLen=aoFeatures.length ; k<kLen ; k++ )
					{
						if ( cOption == aoFeatures[k].cFeature )
						{
							nTmp = aoFeatures[k].fnInit( oSettings );
							if ( nTmp )
							{
								iPushFeature = 1;
							}
							break;
						}
					}
				}
				
				/* Add to the 2D features array */
				if ( iPushFeature == 1 && nTmp !== null )
				{
					if ( typeof oSettings.aanFeatures[cOption] != 'object' )
					{
						oSettings.aanFeatures[cOption] = [];
					}
					oSettings.aanFeatures[cOption].push( nTmp );
					nInsertNode.appendChild( nTmp );
				}
			}
			
			/* Built our DOM structure - replace the holding div with what we want */
			nHolding.parentNode.replaceChild( oSettings.nTableWrapper, nHolding );
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Feature: Filtering
		 */
		
		/*
		 * Function: _fnFeatureHtmlTable
		 * Purpose:  Add any control elements for the table - specifically scrolling
		 * Returns:  node: - Node to add to the DOM
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnFeatureHtmlTable ( oSettings )
		{
			/* Chack if scrolling is enabled or not - if not then leave the DOM unaltered */
			if ( oSettings.oScroll.sX === "" && oSettings.oScroll.sY === "" )
			{
				return oSettings.nTable;
			}
			
			/*
			 * The HTML structure that we want to generate in this function is:
			 *  div - nScroller
			 *    div - nScrollHead
			 *      div - nScrollHeadInner
			 *        table - nScrollHeadTable
			 *          thead - nThead
			 *    div - nScrollBody
			 *      table - oSettings.nTable
			 *        thead - nTheadSize
			 *        tbody - nTbody
			 *    div - nScrollFoot
			 *      div - nScrollFootInner
			 *        table - nScrollFootTable
			 *          tfoot - nTfoot
			 */
			var
			 	nScroller = document.createElement('div'),
			 	nScrollHead = document.createElement('div'),
			 	nScrollHeadInner = document.createElement('div'),
			 	nScrollBody = document.createElement('div'),
			 	nScrollFoot = document.createElement('div'),
			 	nScrollFootInner = document.createElement('div'),
			 	nScrollHeadTable = oSettings.nTable.cloneNode(false),
			 	nScrollFootTable = oSettings.nTable.cloneNode(false),
				nThead = oSettings.nTable.getElementsByTagName('thead')[0],
			 	nTfoot = oSettings.nTable.getElementsByTagName('tfoot').length === 0 ? null : 
					oSettings.nTable.getElementsByTagName('tfoot')[0],
				oClasses = _oExt.oJUIClasses;
			
			nScrollHead.appendChild( nScrollHeadInner );
			nScrollFoot.appendChild( nScrollFootInner );
			nScrollBody.appendChild( oSettings.nTable );
			nScroller.appendChild( nScrollHead );
			nScroller.appendChild( nScrollBody );
			nScrollHeadInner.appendChild( nScrollHeadTable );
			nScrollHeadTable.appendChild( nThead );
			if ( nTfoot !== null )
			{
				nScroller.appendChild( nScrollFoot );
				nScrollFootInner.appendChild( nScrollFootTable );
				nScrollFootTable.appendChild( nTfoot );
			}
			
			nScroller.className = oClasses.sScrollWrapper;
			nScrollHead.className = oClasses.sScrollHead;
			nScrollHeadInner.className = oClasses.sScrollHeadInner;
			nScrollBody.className = oClasses.sScrollBody;
			nScrollFoot.className = oClasses.sScrollFoot;
			nScrollFootInner.className = oClasses.sScrollFootInner;
			
			if ( oSettings.oScroll.bAutoCss )
			{
				nScrollHead.style.overflow = "hidden";
				nScrollHead.style.position = "relative";
				nScrollFoot.style.overflow = "hidden";
				nScrollBody.style.overflow = "auto";
			}
			
			nScrollHead.style.border = "0";
			nScrollFoot.style.border = "0";
			nScrollHeadInner.style.width = "150%"; /* will be overwritten */
			
			/* Modify attributes to respect the clones */
			nScrollHeadTable.removeAttribute('id');
			nScrollHeadTable.style.marginLeft = "0";
			oSettings.nTable.style.marginLeft = "0";
			if ( nTfoot !== null )
			{
				nScrollFootTable.removeAttribute('id');
				nScrollFootTable.style.marginLeft = "0";
			}
			
			/* Move any caption elements from the body to the header */
			var nCaptions = $('>caption', oSettings.nTable);
			for ( var i=0, iLen=nCaptions.length ; i<iLen ; i++ )
			{
				nScrollHeadTable.appendChild( nCaptions[i] );
			}
			
			/*
			 * Sizing
			 */
			/* When xscrolling add the width and a scroller to move the header with the body */
			if ( oSettings.oScroll.sX !== "" )
			{
				nScrollHead.style.width = _fnStringToCss( oSettings.oScroll.sX );
				nScrollBody.style.width = _fnStringToCss( oSettings.oScroll.sX );
				
				if ( nTfoot !== null )
				{
					nScrollFoot.style.width = _fnStringToCss( oSettings.oScroll.sX );	
				}
				
				/* When the body is scrolled, then we also want to scroll the headers */
				$(nScrollBody).scroll( function (e) {
					nScrollHead.scrollLeft = this.scrollLeft;
					
					if ( nTfoot !== null )
					{
						nScrollFoot.scrollLeft = this.scrollLeft;
					}
				} );
			}
			
			/* When yscrolling, add the height */
			if ( oSettings.oScroll.sY !== "" )
			{
				nScrollBody.style.height = _fnStringToCss( oSettings.oScroll.sY );
			}
			
			/* Redraw - align columns across the tables */
			oSettings.aoDrawCallback.push( {
				"fn": _fnScrollDraw,
				"sName": "scrolling"
			} );
			
			/* Infinite scrolling event handlers */
			if ( oSettings.oScroll.bInfinite )
			{
				$(nScrollBody).scroll( function() {
					/* Use a blocker to stop scrolling from loading more data while other data is still loading */
					if ( !oSettings.bDrawing )
					{
						/* Check if we should load the next data set */
						if ( $(this).scrollTop() + $(this).height() > 
							$(oSettings.nTable).height() - oSettings.oScroll.iLoadGap )
						{
							/* Only do the redraw if we have to - we might be at the end of the data */
							if ( oSettings.fnDisplayEnd() < oSettings.fnRecordsDisplay() )
							{
								_fnPageChange( oSettings, 'next' );
								_fnCalculateEnd( oSettings );
								_fnDraw( oSettings );
							}
						}
					}
				} );
			}
			
			oSettings.nScrollHead = nScrollHead;
			oSettings.nScrollFoot = nScrollFoot;
			
			return nScroller;
		}
		
		/*
		 * Function: _fnScrollDraw
		 * Purpose:  Update the various tables for resizing
		 * Returns:  node: - Node to add to the DOM
		 * Inputs:   object:o - dataTables settings object
		 * Notes:    It's a bit of a pig this function, but basically the idea to:
		 *   1. Re-create the table inside the scrolling div
		 *   2. Take live measurements from the DOM
		 *   3. Apply the measurements
		 *   4. Clean up
		 */
		function _fnScrollDraw ( o )
		{
			var
				nScrollHeadInner = o.nScrollHead.getElementsByTagName('div')[0],
				nScrollHeadTable = nScrollHeadInner.getElementsByTagName('table')[0],
				nScrollBody = o.nTable.parentNode,
				i, iLen, j, jLen, anHeadToSize, anHeadSizers, anFootSizers, anFootToSize, oStyle, iVis,
				iWidth, aApplied=[], iSanityWidth;
			
			/*
			 * 1. Re-create the table inside the scrolling div
			 */
			
			/* Remove the old minimised thead and tfoot elements in the inner table */
			var nTheadSize = o.nTable.getElementsByTagName('thead');
			if ( nTheadSize.length > 0 )
			{
				o.nTable.removeChild( nTheadSize[0] );
			}
			
			if ( o.nTFoot !== null )
			{
				/* Remove the old minimised footer element in the cloned header */
				var nTfootSize = o.nTable.getElementsByTagName('tfoot');
				if ( nTfootSize.length > 0 )
				{
					o.nTable.removeChild( nTfootSize[0] );
				}
			}
			
			/* Clone the current header and footer elements and then place it into the inner table */
			nTheadSize = o.nTHead.cloneNode(true);
			o.nTable.insertBefore( nTheadSize, o.nTable.childNodes[0] );
			
			if ( o.nTFoot !== null )
			{
				nTfootSize = o.nTFoot.cloneNode(true);
				o.nTable.insertBefore( nTfootSize, o.nTable.childNodes[1] );
			}
			
			/*
			 * 2. Take live measurements from the DOM - do not alter the DOM itself!
			 */
			
			/* Remove old sizing and apply the calculated column widths
			 * Get the unique column headers in the newly created (cloned) header. We want to apply the
			 * calclated sizes to this header
			 */
			var nThs = _fnGetUniqueThs( nTheadSize );
			for ( i=0, iLen=nThs.length ; i<iLen ; i++ )
			{
				iVis = _fnVisibleToColumnIndex( o, i );
				nThs[i].style.width = o.aoColumns[iVis].sWidth;
			}
			
			if ( o.nTFoot !== null )
			{
				_fnApplyToChildren( function(n) {
					n.style.width = "";
				}, nTfootSize.getElementsByTagName('tr') );
			}
			
			/* Size the table as a whole */
			iSanityWidth = $(o.nTable).outerWidth();
			if ( o.oScroll.sX === "" )
			{
				/* No x scrolling */
				o.nTable.style.width = "100%";
				
				/* I know this is rubbish - but IE7 will make the width of the table when 100% include
				 * the scrollbar - which is shouldn't. This needs feature detection in future - to do
				 */
				if ( $.browser.msie && $.browser.version <= 7 )
				{
					o.nTable.style.width = _fnStringToCss( $(o.nTable).outerWidth()-o.oScroll.iBarWidth );
				}
			}
			else
			{
				if ( o.oScroll.sXInner !== "" )
				{
					/* x scroll inner has been given - use it */
					o.nTable.style.width = _fnStringToCss(o.oScroll.sXInner);
				}
				else if ( iSanityWidth == $(nScrollBody).width() &&
				   $(nScrollBody).height() < $(o.nTable).height() )
				{
					/* There is y-scrolling - try to take account of the y scroll bar */
					o.nTable.style.width = _fnStringToCss( iSanityWidth-o.oScroll.iBarWidth );
					if ( $(o.nTable).outerWidth() > iSanityWidth-o.oScroll.iBarWidth )
					{
						/* Not possible to take account of it */
						o.nTable.style.width = _fnStringToCss( iSanityWidth );
					}
				}
				else
				{
					/* All else fails */
					o.nTable.style.width = _fnStringToCss( iSanityWidth );
				}
			}
			
			/* Recalculate the sanity width - now that we've applied the required width, before it was
			 * a temporary variable. This is required because the column width calculation is done
			 * before this table DOM is created.
			 */
			iSanityWidth = $(o.nTable).outerWidth();
			
			/* We want the hidden header to have zero height, so remove padding and borders. Then
			 * set the width based on the real headers
			 */
			anHeadToSize = o.nTHead.getElementsByTagName('tr');
			anHeadSizers = nTheadSize.getElementsByTagName('tr');
			
			_fnApplyToChildren( function(nSizer, nToSize) {
				oStyle = nSizer.style;
				oStyle.paddingTop = "0";
				oStyle.paddingBottom = "0";
				oStyle.borderTopWidth = "0";
				oStyle.borderBottomWidth = "0";
				oStyle.height = 0;
				
				iWidth = $(nSizer).width();
				nToSize.style.width = _fnStringToCss( iWidth );
				aApplied.push( iWidth );
			}, anHeadSizers, anHeadToSize );
			$(anHeadSizers).height(0);
			
			if ( o.nTFoot !== null )
			{
				/* Clone the current footer and then place it into the body table as a "hidden header" */
				anFootSizers = nTfootSize.getElementsByTagName('tr');
				anFootToSize = o.nTFoot.getElementsByTagName('tr');
				
				_fnApplyToChildren( function(nSizer, nToSize) {
					oStyle = nSizer.style;
					oStyle.paddingTop = "0";
					oStyle.paddingBottom = "0";
					oStyle.borderTopWidth = "0";
					oStyle.borderBottomWidth = "0";
					
					iWidth = $(nSizer).width();
					nToSize.style.width = _fnStringToCss( iWidth );
					aApplied.push( iWidth );
				}, anFootSizers, anFootToSize );
				$(anFootSizers).height(0);
			}
			
			/*
			 * 3. Apply the measurements
			 */
			
			/* "Hide" the header and footer that we used for the sizing. We want to also fix their width
			 * to what they currently are
			 */
			_fnApplyToChildren( function(nSizer) {
				nSizer.innerHTML = "";
				nSizer.style.width = _fnStringToCss( aApplied.shift() );
			}, anHeadSizers );
			
			if ( o.nTFoot !== null )
			{
				_fnApplyToChildren( function(nSizer) {
					nSizer.innerHTML = "";
					nSizer.style.width = _fnStringToCss( aApplied.shift() );
				}, anFootSizers );
			}
			
			/* Sanity check that the table is of a sensible width. If not then we are going to get
			 * misalignment
			 */
			if ( $(o.nTable).outerWidth() < iSanityWidth )
			{
				if ( o.oScroll.sX === "" )
				{
					_fnLog( o, 1, "The table cannot fit into the current element which will cause column"+
						" misalignment. It is suggested that you enable x-scrolling or increase the width"+
						" the table has in which to be drawn" );
				}
				else if ( o.oScroll.sXInner !== "" )
				{
					_fnLog( o, 1, "The table cannot fit into the current element which will cause column"+
						" misalignment. It is suggested that you increase the sScrollXInner property to"+
						" allow it to draw in a larger area, or simply remove that parameter to allow"+
						" automatic calculation" );
				}
			}
			
			
			/*
			 * 4. Clean up
			 */
			
			if ( o.oScroll.sY === "" )
			{
				/* IE7< puts a vertical scrollbar in place (when it shouldn't be) due to subtracting
				 * the scrollbar height from the visible display, rather than adding it on. We need to
				 * set the height in order to sort this. Don't want to do it in any other browsers.
				 */
				if ( $.browser.msie && $.browser.version <= 7 )
				{
					nScrollBody.style.height = _fnStringToCss( o.nTable.offsetHeight+o.oScroll.iBarWidth );
				}
			}
			
			if ( o.oScroll.sY !== "" && o.oScroll.bCollapse )
			{
				nScrollBody.style.height = _fnStringToCss( o.oScroll.sY );
				
				var iExtra = (o.oScroll.sX !== "" && o.nTable.offsetWidth > nScrollBody.offsetWidth) ?
				 	o.oScroll.iBarWidth : 0;
				if ( o.nTable.offsetHeight < nScrollBody.offsetHeight )
				{
					nScrollBody.style.height = _fnStringToCss( $(o.nTable).height()+iExtra );
				}
			}
			
			/* Finally set the width's of the header and footer tables */
			var iOuterWidth = $(o.nTable).outerWidth();
			nScrollHeadTable.style.width = _fnStringToCss( iOuterWidth );
			nScrollHeadInner.style.width = _fnStringToCss( iOuterWidth+o.oScroll.iBarWidth );
			nScrollHeadInner.parentNode.style.width = _fnStringToCss( $(nScrollBody).width() );
			
			if ( o.nTFoot !== null )
			{
				var
					nScrollFootInner = o.nScrollFoot.getElementsByTagName('div')[0],
					nScrollFootTable = nScrollFootInner.getElementsByTagName('table')[0];
				
				nScrollFootInner.style.width = _fnStringToCss( o.nTable.offsetWidth+o.oScroll.iBarWidth );
				nScrollFootTable.style.width = _fnStringToCss( o.nTable.offsetWidth );
			}
			
			/* If sorting or filtering has occured, jump the scrolling back to the top */
			if ( o.bSorted || o.bFiltered )
			{
				nScrollBody.scrollTop = 0;
			}
		}
		
		/*
		 * Function: _fnAjustColumnSizing
		 * Purpose:  Ajust the table column widths for new data
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 * Notes:    You would probably want to do a redraw after calling this function!
		 */
		function _fnAjustColumnSizing ( oSettings )
		{
			/* Not interested in doing column width calculation if autowidth is disabled */
			if ( oSettings.oFeatures.bAutoWidth === false )
			{
				return false;
			}
			
			_fnCalculateColumnWidths( oSettings );
			for ( var i=0 , iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
			{
				oSettings.aoColumns[i].nTh.style.width = oSettings.aoColumns[i].sWidth;
			}
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Feature: Filtering
		 */
		
		/*
		 * Function: _fnFeatureHtmlFilter
		 * Purpose:  Generate the node required for filtering text
		 * Returns:  node
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnFeatureHtmlFilter ( oSettings )
		{
			var nFilter = document.createElement( 'div' );
			if ( oSettings.sTableId !== '' && typeof oSettings.aanFeatures.f == "undefined" )
			{
				nFilter.setAttribute( 'id', oSettings.sTableId+'_filter' );
			}
			nFilter.className = oSettings.oClasses.sFilter;
			var sSpace = oSettings.oLanguage.sSearch==="" ? "" : " ";
			var iconSearch = '<span class="ui-icon ui-icon-search right-icon ui-icon-default"></span>';
			nFilter.innerHTML = oSettings.oLanguage.sSearch+sSpace+'<input type="text" />'+iconSearch;
			
			var jqFilter = $("input", nFilter);
			jqFilter.val( oSettings.oPreviousSearch.sSearch.replace('"','&quot;') );
			jqFilter.keyup( function(e) {
				/* Update all other filter input elements for the new display */
				var n = oSettings.aanFeatures.f;
				for ( var i=0, iLen=n.length ; i<iLen ; i++ )
				{
					if ( n[i] != this.parentNode )
					{
						$('input', n[i]).val( this.value );
					}
				}
				
				/* Now do the filter */
				if ( this.value != oSettings.oPreviousSearch.sSearch )
				{
					_fnFilterComplete( oSettings, { 
						"sSearch": this.value, 
						"bRegex":  oSettings.oPreviousSearch.bRegex,
						"bSmart":  oSettings.oPreviousSearch.bSmart 
					} );
				}
			} );
			
			jqFilter.keypress( function(e) {
				/* Prevent default */
				if ( e.keyCode == 13 )
				{
					return false;
				}
			} );
			
			return nFilter;
		}
		
		/*
		 * Function: _fnFilterComplete
		 * Purpose:  Filter the table using both the global filter and column based filtering
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           object:oSearch: search information
		 *           int:iForce - optional - force a research of the master array (1) or not (undefined or 0)
		 */
		function _fnFilterComplete ( oSettings, oInput, iForce )
		{
			/* Filter on everything */
			_fnFilter( oSettings, oInput.sSearch, iForce, oInput.bRegex, oInput.bSmart );
			
			/* Now do the individual column filter */
			for ( var i=0 ; i<oSettings.aoPreSearchCols.length ; i++ )
			{
				_fnFilterColumn( oSettings, oSettings.aoPreSearchCols[i].sSearch, i, 
					oSettings.aoPreSearchCols[i].bRegex, oSettings.aoPreSearchCols[i].bSmart );
			}
			
			/* Custom filtering */
			if ( _oExt.afnFiltering.length !== 0 )
			{
				_fnFilterCustom( oSettings );
			}
			
			/* Tell the draw function we have been filtering */
			oSettings.bFiltered = true;
			
			/* Redraw the table */
			oSettings._iDisplayStart = 0;
			_fnCalculateEnd( oSettings );
			_fnDraw( oSettings );
			
			/* Rebuild search array 'offline' */
			_fnBuildSearchArray( oSettings, 0 );
		}
		
		/*
		 * Function: _fnFilterCustom
		 * Purpose:  Apply custom filtering functions
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnFilterCustom( oSettings )
		{
			var afnFilters = _oExt.afnFiltering;
			for ( var i=0, iLen=afnFilters.length ; i<iLen ; i++ )
			{
				var iCorrector = 0;
				for ( var j=0, jLen=oSettings.aiDisplay.length ; j<jLen ; j++ )
				{
					var iDisIndex = oSettings.aiDisplay[j-iCorrector];
					
					/* Check if we should use this row based on the filtering function */
					if ( !afnFilters[i]( oSettings, oSettings.aoData[iDisIndex]._aData, iDisIndex ) )
					{
						oSettings.aiDisplay.splice( j-iCorrector, 1 );
						iCorrector++;
					}
				}
			}
		}
		
		/*
		 * Function: _fnFilterColumn
		 * Purpose:  Filter the table on a per-column basis
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           string:sInput - string to filter on
		 *           int:iColumn - column to filter
		 *           bool:bRegex - treat search string as a regular expression or not
		 *           bool:bSmart - use smart filtering or not
		 */
		function _fnFilterColumn ( oSettings, sInput, iColumn, bRegex, bSmart )
		{
			if ( sInput === "" )
			{
				return;
			}
			
			var iIndexCorrector = 0;
			var rpSearch = _fnFilterCreateSearch( sInput, bRegex, bSmart );
			
			for ( var i=oSettings.aiDisplay.length-1 ; i>=0 ; i-- )
			{
				var sData = _fnDataToSearch( oSettings.aoData[ oSettings.aiDisplay[i] ]._aData[iColumn],
					oSettings.aoColumns[iColumn].sType );
				if ( ! rpSearch.test( sData ) )
				{
					oSettings.aiDisplay.splice( i, 1 );
					iIndexCorrector++;
				}
			}
		}
		
		/*
		 * Function: _fnFilter
		 * Purpose:  Filter the data table based on user input and draw the table
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           string:sInput - string to filter on
		 *           int:iForce - optional - force a research of the master array (1) or not (undefined or 0)
		 *           bool:bRegex - treat as a regular expression or not
		 *           bool:bSmart - perform smart filtering or not
		 */
		function _fnFilter( oSettings, sInput, iForce, bRegex, bSmart )
		{
			var i;
			var rpSearch = _fnFilterCreateSearch( sInput, bRegex, bSmart );
			
			/* Check if we are forcing or not - optional parameter */
			if ( typeof iForce == 'undefined' || iForce === null )
			{
				iForce = 0;
			}
			
			/* Need to take account of custom filtering functions - always filter */
			if ( _oExt.afnFiltering.length !== 0 )
			{
				iForce = 1;
			}
			
			/*
			 * If the input is blank - we want the full data set
			 */
			if ( sInput.length <= 0 )
			{
				oSettings.aiDisplay.splice( 0, oSettings.aiDisplay.length);
				oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			}
			else
			{
				/*
				 * We are starting a new search or the new search string is smaller 
				 * then the old one (i.e. delete). Search from the master array
			 	 */
				if ( oSettings.aiDisplay.length == oSettings.aiDisplayMaster.length ||
					   oSettings.oPreviousSearch.sSearch.length > sInput.length || iForce == 1 ||
					   sInput.indexOf(oSettings.oPreviousSearch.sSearch) !== 0 )
				{
					/* Nuke the old display array - we are going to rebuild it */
					oSettings.aiDisplay.splice( 0, oSettings.aiDisplay.length);
					
					/* Force a rebuild of the search array */
					_fnBuildSearchArray( oSettings, 1 );
					
					/* Search through all records to populate the search array
					 * The the oSettings.aiDisplayMaster and asDataSearch arrays have 1 to 1 
					 * mapping
					 */
					for ( i=0 ; i<oSettings.aiDisplayMaster.length ; i++ )
					{
						if ( rpSearch.test(oSettings.asDataSearch[i]) )
						{
							oSettings.aiDisplay.push( oSettings.aiDisplayMaster[i] );
						}
					}
			  }
			  else
				{
			  	/* Using old search array - refine it - do it this way for speed
			  	 * Don't have to search the whole master array again
			 		 */
			  	var iIndexCorrector = 0;
			  	
			  	/* Search the current results */
			  	for ( i=0 ; i<oSettings.asDataSearch.length ; i++ )
					{
			  		if ( ! rpSearch.test(oSettings.asDataSearch[i]) )
						{
			  			oSettings.aiDisplay.splice( i-iIndexCorrector, 1 );
			  			iIndexCorrector++;
			  		}
			  	}
			  }
			}
			oSettings.oPreviousSearch.sSearch = sInput;
			oSettings.oPreviousSearch.bRegex = bRegex;
			oSettings.oPreviousSearch.bSmart = bSmart;
		}
		
		/*
		 * Function: _fnBuildSearchArray
		 * Purpose:  Create an array which can be quickly search through
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           int:iMaster - use the master data array - optional
		 */
		function _fnBuildSearchArray ( oSettings, iMaster )
		{
			/* Clear out the old data */
			oSettings.asDataSearch.splice( 0, oSettings.asDataSearch.length );
			
			var aArray = (typeof iMaster != 'undefined' && iMaster == 1) ?
			 	oSettings.aiDisplayMaster : oSettings.aiDisplay;
			
			for ( var i=0, iLen=aArray.length ; i<iLen ; i++ )
			{
				oSettings.asDataSearch[i] = _fnBuildSearchRow( oSettings, 
					oSettings.aoData[ aArray[i] ]._aData );
			}
		}
		
		/*
		 * Function: _fnBuildSearchRow
		 * Purpose:  Create a searchable string from a single data row
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           array:aData - aoData[]._aData array to use for the data to search
		 */
		function _fnBuildSearchRow( oSettings, aData )
		{
			var sSearch = '';
			var nTmp = document.createElement('div');
			
			for ( var j=0, jLen=oSettings.aoColumns.length ; j<jLen ; j++ )
			{
				if ( oSettings.aoColumns[j].bSearchable )
				{
					var sData = aData[j];
					sSearch += _fnDataToSearch( sData, oSettings.aoColumns[j].sType )+'  ';
				}
			}
			
			/* If it looks like there is an HTML entity in the string, attempt to decode it */
			if ( sSearch.indexOf('&') !== -1 )
			{
				nTmp.innerHTML = sSearch;
				sSearch = nTmp.textContent ? nTmp.textContent : nTmp.innerText;
				
				/* IE and Opera appear to put an newline where there is a <br> tag - remove it */
				sSearch = sSearch.replace(/\n/g," ").replace(/\r/g,"");
			}
			
			return sSearch;
		}
		
		/*
		 * Function: _fnFilterCreateSearch
		 * Purpose:  Build a regular expression object suitable for searching a table
		 * Returns:  RegExp: - constructed object
		 * Inputs:   string:sSearch - string to search for
		 *           bool:bRegex - treat as a regular expression or not
		 *           bool:bSmart - perform smart filtering or not
		 */
		function _fnFilterCreateSearch( sSearch, bRegex, bSmart )
		{
			var asSearch, sRegExpString;
			
			if ( bSmart )
			{
				/* Generate the regular expression to use. Something along the lines of:
				 * ^(?=.*?\bone\b)(?=.*?\btwo\b)(?=.*?\bthree\b).*$
				 */
				asSearch = bRegex ? sSearch.split( ' ' ) : _fnEscapeRegex( sSearch ).split( ' ' );
				sRegExpString = '^(?=.*?'+asSearch.join( ')(?=.*?' )+').*$';
				return new RegExp( sRegExpString, "i" );
			}
			else
			{
				sSearch = bRegex ? sSearch : _fnEscapeRegex( sSearch );
				return new RegExp( sSearch, "i" );
			}
		}
		
		/*
		 * Function: _fnDataToSearch
		 * Purpose:  Convert raw data into something that the user can search on
		 * Returns:  string: - search string
		 * Inputs:   string:sData - data to be modified
		 *           string:sType - data type
		 */
		function _fnDataToSearch ( sData, sType )
		{
			if ( typeof _oExt.ofnSearch[sType] == "function" )
			{
				return _oExt.ofnSearch[sType]( sData );
			}
			else if ( sType == "html" )
			{
				return sData.replace(/\n/g," ").replace( /<.*?>/g, "" );
			}
			else if ( typeof sData == "string" )
			{
				return sData.replace(/\n/g," ");
			}
			return sData;
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Feature: Sorting
		 */
		
		/*
	 	 * Function: _fnSort
		 * Purpose:  Change the order of the table
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           bool:bApplyClasses - optional - should we apply classes or not
		 * Notes:    We always sort the master array and then apply a filter again
		 *   if it is needed. This probably isn't optimal - but atm I can't think
		 *   of any other way which is (each has disadvantages). we want to sort aiDisplayMaster - 
		 *   but according to aoData[]._aData
		 */
		function _fnSort ( oSettings, bApplyClasses )
		{
			var
				iDataSort, iDataType,
				i, iLen, j, jLen,
				aaSort = [],
			 	aiOrig = [],
				oSort = _oExt.oSort,
				aoData = oSettings.aoData,
				aoColumns = oSettings.aoColumns;
			
			/* No sorting required if server-side or no sorting array */
			if ( !oSettings.oFeatures.bServerSide && 
				(oSettings.aaSorting.length !== 0 || oSettings.aaSortingFixed !== null) )
			{
				if ( oSettings.aaSortingFixed !== null )
				{
					aaSort = oSettings.aaSortingFixed.concat( oSettings.aaSorting );
				}
				else
				{
					aaSort = oSettings.aaSorting.slice();
				}
				
				/* If there is a sorting data type, and a fuction belonging to it, then we need to
				 * get the data from the developer's function and apply it for this column
				 */
				for ( i=0 ; i<aaSort.length ; i++ )
				{
					var iColumn = aaSort[i][0];
					var iVisColumn = _fnColumnIndexToVisible( oSettings, iColumn );
					var sDataType = oSettings.aoColumns[ iColumn ].sSortDataType;
					if ( typeof _oExt.afnSortData[sDataType] != 'undefined' )
					{
						var aData = _oExt.afnSortData[sDataType]( oSettings, iColumn, iVisColumn );
						for ( j=0, jLen=aoData.length ; j<jLen ; j++ )
						{
							aoData[j]._aData[iColumn] = aData[j];
						}
					}
				}
				
				/* Create a value - key array of the current row positions such that we can use their
				 * current position during the sort, if values match, in order to perform stable sorting
				 */
				for ( i=0, iLen=oSettings.aiDisplayMaster.length ; i<iLen ; i++ )
				{
					aiOrig[ oSettings.aiDisplayMaster[i] ] = i;
				}
				
				/* Do the sort - here we want multi-column sorting based on a given data source (column)
				 * and sorting function (from oSort) in a certain direction. It's reasonably complex to
				 * follow on it's own, but this is what we want (example two column sorting):
				 *  fnLocalSorting = function(a,b){
				 *  	var iTest;
				 *  	iTest = oSort['string-asc']('data11', 'data12');
				 *  	if (iTest !== 0)
				 *  		return iTest;
				 *    iTest = oSort['numeric-desc']('data21', 'data22');
				 *    if (iTest !== 0)
				 *  		return iTest;
				 *  	return oSort['numeric-asc']( aiOrig[a], aiOrig[b] );
				 *  }
				 * Basically we have a test for each sorting column, if the data in that column is equal,
				 * test the next column. If all columns match, then we use a numeric sort on the row 
				 * positions in the original data array to provide a stable sort.
				 */
				var iSortLen = aaSort.length;
				oSettings.aiDisplayMaster.sort( function ( a, b ) {
					var iTest;
					for ( i=0 ; i<iSortLen ; i++ )
					{
						iDataSort = aoColumns[ aaSort[i][0] ].iDataSort;
						iDataType = aoColumns[ iDataSort ].sType;
						iTest = oSort[ iDataType+"-"+aaSort[i][1] ](
							aoData[a]._aData[iDataSort],
							aoData[b]._aData[iDataSort]
						);
						
						if ( iTest !== 0 )
						{
							return iTest;
						}
					}
					
					return oSort['numeric-asc']( aiOrig[a], aiOrig[b] );
				} );
			}
			
			/* Alter the sorting classes to take account of the changes */
			if ( typeof bApplyClasses == 'undefined' || bApplyClasses )
			{
				_fnSortingClasses( oSettings );
			}
			
			/* Tell the draw function that we have sorted the data */
			oSettings.bSorted = true;
			
			/* Copy the master data into the draw array and re-draw */
			if ( oSettings.oFeatures.bFilter )
			{
				/* _fnFilter() will redraw the table for us */
				_fnFilterComplete( oSettings, oSettings.oPreviousSearch, 1 );
			}
			else
			{
				oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
				oSettings._iDisplayStart = 0; /* reset display back to page 0 */
				_fnCalculateEnd( oSettings );
				_fnDraw( oSettings );
			}
		}
		
		/*
		 * Function: _fnSortAttachListener
		 * Purpose:  Attach a sort handler (click) to a node
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           node:nNode - node to attach the handler to
		 *           int:iDataIndex - column sorting index
		 *           function:fnCallback - callback function - optional
		 */
		function _fnSortAttachListener ( oSettings, nNode, iDataIndex, fnCallback )
		{
			$(nNode).click( function (e) {
				var eventTarget = $(e.target);
				if(eventTarget.is("select, input")){
					return true;
				}
				/* If the column is not sortable - don't to anything */
				if ( oSettings.aoColumns[iDataIndex].bSortable === false )
				{
					return;
				}
				
				/*
				 * This is a little bit odd I admit... I declare a temporary function inside the scope of
				 * _fnDrawHead and the click handler in order that the code presented here can be used 
				 * twice - once for when bProcessing is enabled, and another time for when it is 
				 * disabled, as we need to perform slightly different actions.
				 *   Basically the issue here is that the Javascript engine in modern browsers don't 
				 * appear to allow the rendering engine to update the display while it is still excuting
				 * it's thread (well - it does but only after long intervals). This means that the 
				 * 'processing' display doesn't appear for a table sort. To break the js thread up a bit
				 * I force an execution break by using setTimeout - but this breaks the expected 
				 * thread continuation for the end-developer's point of view (their code would execute
				 * too early), so we on;y do it when we absolutely have to.
				 */
				var fnInnerSorting = function () {
					var iColumn, iNextSort;
					
					/* If the control key is pressed then we are multipe column sorting */
					if ( e.ctrltKey )
					{
						/* Are we already doing some kind of sort on this column? */
						var bFound = false;
						for ( var i=0 ; i<oSettings.aaSorting.length ; i++ )
						{
							if ( oSettings.aaSorting[i][0] == iDataIndex )
							{
								bFound = true;
								iColumn = oSettings.aaSorting[i][0];
								iNextSort = oSettings.aaSorting[i][2]+1;
								
								if ( typeof oSettings.aoColumns[iColumn].asSorting[iNextSort] == 'undefined' )
								{
									/* Reached the end of the sorting options, remove from multi-col sort */
									oSettings.aaSorting.splice( i, 1 );
								}
								else
								{
									/* Move onto next sorting direction */
									oSettings.aaSorting[i][1] = oSettings.aoColumns[iColumn].asSorting[iNextSort];
									oSettings.aaSorting[i][2] = iNextSort;
								}
								break;
							}
						}
						
						/* No sort yet - add it in */
						if ( bFound === false )
						{
							oSettings.aaSorting.push( [ iDataIndex, 
								oSettings.aoColumns[iDataIndex].asSorting[0], 0 ] );
						}
					}
					else
					{
						/* If no shift key then single column sort */
						if ( oSettings.aaSorting.length == 1 && oSettings.aaSorting[0][0] == iDataIndex )
						{
							iColumn = oSettings.aaSorting[0][0];
							iNextSort = oSettings.aaSorting[0][2]+1;
							if ( typeof oSettings.aoColumns[iColumn].asSorting[iNextSort] == 'undefined' )
							{
								iNextSort = 0;
							}
							oSettings.aaSorting[0][1] = oSettings.aoColumns[iColumn].asSorting[iNextSort];
							oSettings.aaSorting[0][2] = iNextSort;
						}
						else
						{
							oSettings.aaSorting.splice( 0, oSettings.aaSorting.length );
							oSettings.aaSorting.push( [ iDataIndex, 
								oSettings.aoColumns[iDataIndex].asSorting[0], 0 ] );
						}
					}
					
					/* Run the sort */
					_fnSort( oSettings );
				}; /* /fnInnerSorting */
				
				if ( !oSettings.oFeatures.bProcessing )
				{
					fnInnerSorting();
				}
				else
				{
					_fnProcessingDisplay( oSettings, true );
					setTimeout( function() {
						fnInnerSorting();
						if ( !oSettings.oFeatures.bServerSide )
						{
							_fnProcessingDisplay( oSettings, false );
						}
					}, 0 );
				}
				
				/* Call the user specified callback function - used for async user interaction */
				if ( typeof fnCallback == 'function' )
				{
					fnCallback( oSettings );
				}
			} );
		}
		
		/*
		 * Function: _fnSortingClasses
		 * Purpose:  Set the sortting classes on the header
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 * Notes:    It is safe to call this function when bSort and bSortClasses are false
		 */
		function _fnSortingClasses( oSettings )
		{
			var i, iLen, j, jLen, iFound;
			var aaSort, sClass;
			var iColumns = oSettings.aoColumns.length;
			var oClasses = oSettings.oClasses;
			
			for ( i=0 ; i<iColumns ; i++ )
			{
				if ( oSettings.aoColumns[i].bSortable )
				{
					$(oSettings.aoColumns[i].nTh).removeClass( oClasses.sSortAsc +" "+ oClasses.sSortDesc +
				 		" "+ oSettings.aoColumns[i].sSortingClass );
				}
			}
			
			if ( oSettings.aaSortingFixed !== null )
			{
				aaSort = oSettings.aaSortingFixed.concat( oSettings.aaSorting );
			}
			else
			{
				aaSort = oSettings.aaSorting.slice();
			}
			
			/* Apply the required classes to the header */
			for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
			{
				if ( oSettings.aoColumns[i].bSortable )
				{
					sClass = oSettings.aoColumns[i].sSortingClass;
					iFound = -1;
					for ( j=0 ; j<aaSort.length ; j++ )
					{
						if ( aaSort[j][0] == i )
						{
							sClass = ( aaSort[j][1] == "asc" ) ?
								oClasses.sSortAsc : oClasses.sSortDesc;
							iFound = j;
							break;
						}
					}
					$(oSettings.aoColumns[i].nTh).addClass( sClass );
					
					if ( oSettings.bJUI )
					{
						/* jQuery UI uses extra markup */
						var jqSpan = $("span.dt-icon-sort", oSettings.aoColumns[i].nTh);
						jqSpan.removeClass(oClasses.sSortJUIAsc +" "+ oClasses.sSortJUIDesc +" "+ 
							oClasses.sSortJUI +" "+ oClasses.sSortJUIAscAllowed +" "+ oClasses.sSortJUIDescAllowed );
						
						var sSpanClass;
						if ( iFound == -1 )
						{
						 	sSpanClass = oSettings.aoColumns[i].sSortingClassJUI;
						}
						else if ( aaSort[iFound][1] == "asc" )
						{
							sSpanClass = oClasses.sSortJUIAsc;
						}
						else
						{
							sSpanClass = oClasses.sSortJUIDesc;
						}
						
						jqSpan.addClass( sSpanClass );
					}
				}
				else
				{
					/* No sorting on this column, so add the base class. This will have been assigned by
					 * _fnAddColumn
					 */
					$(oSettings.aoColumns[i].nTh).addClass( oSettings.aoColumns[i].sSortingClass );
				}
			}
			
			/* 
			 * Apply the required classes to the table body
			 * Note that this is given as a feature switch since it can significantly slow down a sort
			 * on large data sets (adding and removing of classes is always slow at the best of times..)
			 * Further to this, note that this code is admitadly fairly ugly. It could be made a lot 
			 * simpiler using jQuery selectors and add/removeClass, but that is significantly slower
			 * (on the order of 5 times slower) - hence the direct DOM manipulation here.
			 */
			sClass = oClasses.sSortColumn;
			
			if ( oSettings.oFeatures.bSort && oSettings.oFeatures.bSortClasses )
			{
				var nTds = _fnGetTdNodes( oSettings );
				
				/* Remove the old classes */
				if ( nTds.length >= iColumns )
				{
					for ( i=0 ; i<iColumns ; i++ )
					{
						if ( nTds[i].className.indexOf(sClass+"1") != -1 )
						{
							for ( j=0, jLen=(nTds.length/iColumns) ; j<jLen ; j++ )
							{
								nTds[(iColumns*j)+i].className = 
									$.trim( nTds[(iColumns*j)+i].className.replace( sClass+"1", "" ) );
							}
						}
						else if ( nTds[i].className.indexOf(sClass+"2") != -1 )
						{
							for ( j=0, jLen=(nTds.length/iColumns) ; j<jLen ; j++ )
							{
								nTds[(iColumns*j)+i].className = 
									$.trim( nTds[(iColumns*j)+i].className.replace( sClass+"2", "" ) );
							}
						}
						else if ( nTds[i].className.indexOf(sClass+"3") != -1 )
						{
							for ( j=0, jLen=(nTds.length/iColumns) ; j<jLen ; j++ )
							{
								nTds[(iColumns*j)+i].className = 
									$.trim( nTds[(iColumns*j)+i].className.replace( " "+sClass+"3", "" ) );
							}
						}
					}
				}
				
				/* Add the new classes to the table */
				var iClass = 1, iTargetCol;
				for ( i=0 ; i<aaSort.length ; i++ )
				{
					iTargetCol = parseInt( aaSort[i][0], 10 );
					for ( j=0, jLen=(nTds.length/iColumns) ; j<jLen ; j++ )
					{
						nTds[(iColumns*j)+iTargetCol].className += " "+sClass+iClass;
					}
					
					if ( iClass < 3 )
					{
						iClass++;
					}
				}
			}
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Feature: Pagination. Note that most of the paging logic is done in 
		 * _oExt.oPagination
		 */
		
		/*
		 * Function: _fnFeatureHtmlPaginate
		 * Purpose:  Generate the node required for default pagination
		 * Returns:  node
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnFeatureHtmlPaginate ( oSettings )
		{
			if ( oSettings.oScroll.bInfinite )
			{
				return null;
			}
			
			var nPaginate = document.createElement( 'div' );
			nPaginate.className = oSettings.oClasses.sPaging+oSettings.sPaginationType;
			
			_oExt.oPagination[ oSettings.sPaginationType ].fnInit( oSettings, nPaginate, 
				function( oSettings ) {
					_fnCalculateEnd( oSettings );
					_fnDraw( oSettings );
				}
			);
			
			/* Add a draw callback for the pagination on first instance, to update the paging display */
			if ( typeof oSettings.aanFeatures.p == "undefined" )
			{
				oSettings.aoDrawCallback.push( {
					"fn": function( oSettings ) {
						_oExt.oPagination[ oSettings.sPaginationType ].fnUpdate( oSettings, function( oSettings ) {
							_fnCalculateEnd( oSettings );
							_fnDraw( oSettings );
						} );
					},
					"sName": "pagination"
				} );
			}
			return nPaginate;
		}
		
		/*
		 * Function: _fnPageChange
		 * Purpose:  Alter the display settings to change the page
		 * Returns:  bool:true - page has changed, false - no change (no effect) eg 'first' on page 1
		 * Inputs:   object:oSettings - dataTables settings object
		 *           string:sAction - paging action to take: "first", "previous", "next" or "last"
		 */
		function _fnPageChange ( oSettings, sAction )
		{
			var iOldStart = oSettings._iDisplayStart;
			
			if ( sAction == "first" )
			{
				oSettings._iDisplayStart = 0;
			}
			else if ( sAction == "previous" )
			{
				oSettings._iDisplayStart = oSettings._iDisplayLength>=0 ?
					oSettings._iDisplayStart - oSettings._iDisplayLength :
					0;
				
				/* Correct for underrun */
				if ( oSettings._iDisplayStart < 0 )
				{
				  oSettings._iDisplayStart = 0;
				}
			}
			else if ( sAction == "next" )
			{
				if ( oSettings._iDisplayLength >= 0 )
				{
					/* Make sure we are not over running the display array */
					if ( oSettings._iDisplayStart + oSettings._iDisplayLength < oSettings.fnRecordsDisplay() )
					{
						oSettings._iDisplayStart += oSettings._iDisplayLength;
					}
				}
				else
				{
					oSettings._iDisplayStart = 0;
				}
			}
			else if ( sAction == "last" )
			{
				if ( oSettings._iDisplayLength >= 0 )
				{
					var iPages = parseInt( (oSettings.fnRecordsDisplay()-1) / oSettings._iDisplayLength, 10 ) + 1;
					oSettings._iDisplayStart = (iPages-1) * oSettings._iDisplayLength;
				}
				else
				{
					oSettings._iDisplayStart = 0;
				}
			}
			else
			{
				_fnLog( oSettings, 0, "Unknown paging action: "+sAction );
			}
			
			return iOldStart != oSettings._iDisplayStart;
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Feature: HTML info
		 */
		
		/*
		 * Function: _fnFeatureHtmlInfo
		 * Purpose:  Generate the node required for the info display
		 * Returns:  node
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnFeatureHtmlInfo ( oSettings )
		{
			var nInfo = document.createElement( 'div' );
			nInfo.className = oSettings.oClasses.sInfo;
			
			/* Actions that are to be taken once only for this feature */
			if ( typeof oSettings.aanFeatures.i == "undefined" )
			{
				/* Add draw callback */
				oSettings.aoDrawCallback.push( {
					"fn": _fnUpdateInfo,
					"sName": "information"
				} );
				
				/* Add id */
				if ( oSettings.sTableId !== '' )
				{
					nInfo.setAttribute( 'id', oSettings.sTableId+'_info' );
				}
			}
			
			return nInfo;
		}
		
		/*
		 * Function: _fnUpdateInfo
		 * Purpose:  Update the information elements in the display
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnUpdateInfo ( oSettings )
		{
			/* Show information about the table */
			if ( !oSettings.oFeatures.bInfo || oSettings.aanFeatures.i.length === 0 )
			{
				return;
			}
			
			var
				iStart = oSettings._iDisplayStart+1, iEnd = oSettings.fnDisplayEnd(),
				iMax = oSettings.fnRecordsTotal(), iTotal = oSettings.fnRecordsDisplay(),
				sStart = oSettings.fnFormatNumber( iStart ), sEnd = oSettings.fnFormatNumber( iEnd ),
				sMax = oSettings.fnFormatNumber( iMax ), sTotal = oSettings.fnFormatNumber( iTotal ),
				sOut;
			
			/* When infinite scrolling, we are always starting at 1. _iDisplayStart is used only
			 * internally
			 */
			if ( oSettings.oScroll.bInfinite )
			{
				sStart = oSettings.fnFormatNumber( 1 );
			}
			
			if ( oSettings.fnRecordsDisplay() === 0 && 
				   oSettings.fnRecordsDisplay() == oSettings.fnRecordsTotal() )
			{
				/* Empty record set */
				sOut = oSettings.oLanguage.sInfoEmpty+ oSettings.oLanguage.sInfoPostFix;
			}
			else if ( oSettings.fnRecordsDisplay() === 0 )
			{
				/* Rmpty record set after filtering */
				sOut = oSettings.oLanguage.sInfoEmpty +' '+ 
					oSettings.oLanguage.sInfoFiltered.replace('_MAX_', sMax)+
						oSettings.oLanguage.sInfoPostFix;
			}
			else if(!oSettings.oFeatures.bPaginate){
				sOut = sTotal+" Registros"
			}
			else if ( oSettings.fnRecordsDisplay() == oSettings.fnRecordsTotal() )
			{
				/* Normal record set */
				sOut = oSettings.oLanguage.sInfo.
						replace('_START_', sStart).
						replace('_END_',   sEnd).
						replace('_TOTAL_', sTotal)+ 
					oSettings.oLanguage.sInfoPostFix;
			}
			else
			{
				/* Record set after filtering */
				sOut = oSettings.oLanguage.sInfo.
						replace('_START_', sStart).
						replace('_END_',   sEnd).
						replace('_TOTAL_', sTotal) +' '+ 
					oSettings.oLanguage.sInfoFiltered.replace('_MAX_', 
						oSettings.fnFormatNumber(oSettings.fnRecordsTotal()))+ 
					oSettings.oLanguage.sInfoPostFix;
			}
			
			if ( oSettings.oLanguage.fnInfoCallback !== null )
			{
				sOut = oSettings.oLanguage.fnInfoCallback( oSettings, iStart, iEnd, iMax, iTotal, sOut );
			}
			
			var n = oSettings.aanFeatures.i;
			for ( var i=0, iLen=n.length ; i<iLen ; i++ )
			{
				$(n[i]).html( sOut );
			}
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Feature: Length change
		 */
		
		/*
		 * Function: _fnFeatureHtmlLength
		 * Purpose:  Generate the node required for user display length changing
		 * Returns:  node
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnFeatureHtmlLength( oSettings )
		{
			/* This can be overruled by not using the _MENU_ var/macro in the language variable */
			var sName = (oSettings.sTableId === "") ? "" : 'name="'+oSettings.sTableId+'_length"';
			var sStdMenu = '<input size="4" '+sName+' value="'+oSettings._iDisplayLength+'"/>';
			var i, iLen;

			var nLength = document.createElement( 'div' );
			if ( oSettings.sTableId !== '' && typeof oSettings.aanFeatures.l == "undefined" )
			{
				nLength.setAttribute( 'id', oSettings.sTableId+'_length' );
			}
			nLength.className = oSettings.oClasses.sLength;
			nLength.innerHTML = oSettings.oLanguage.sLengthMenu.replace( '_MENU_', sStdMenu );


			$('input', nLength).keyup( function(e) {
				var iVal = $(this).val();
				if(isNaN(iVal)){
					$(this).val(50);
					iVal = 50;
				}

				/* Redraw the table */
				oSettings._iDisplayLength = parseInt(iVal, 10);
				oSettings.oApi._fnCalculateEnd( oSettings );

				oSettings.oApi._fnDraw( oSettings );
			} );

			return nLength;
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Feature: Processing incidator
		 */
		
		/*
		 * Function: _fnFeatureHtmlProcessing
		 * Purpose:  Generate the node required for the processing node
		 * Returns:  node
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnFeatureHtmlProcessing ( oSettings )
		{
			var nProcessing = document.createElement( 'div' );
			
			if ( oSettings.sTableId !== '' && typeof oSettings.aanFeatures.r == "undefined" )
			{
				nProcessing.setAttribute( 'id', oSettings.sTableId+'_processing' );
			}
			nProcessing.innerHTML = oSettings.oLanguage.sProcessing;
			nProcessing.className = oSettings.oClasses.sProcessing;
			oSettings.nTable.parentNode.insertBefore( nProcessing, oSettings.nTable );
			
			return nProcessing;
		}
		
		/*
		 * Function: _fnProcessingDisplay
		 * Purpose:  Display or hide the processing indicator
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           bool:
		 *   true - show the processing indicator
		 *   false - don't show
		 */
		function _fnProcessingDisplay ( oSettings, bShow )
		{
			if ( oSettings.oFeatures.bProcessing )
			{
				var an = oSettings.aanFeatures.r;
				for ( var i=0, iLen=an.length ; i<iLen ; i++ )
				{
					an[i].style.visibility = bShow ? "visible" : "hidden";
				}
			}
		}
		
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Support functions
		 */
		
		/*
		 * Function: _fnVisibleToColumnIndex
		 * Purpose:  Covert the index of a visible column to the index in the data array (take account
		 *   of hidden columns)
		 * Returns:  int:i - the data index
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnVisibleToColumnIndex( oSettings, iMatch )
		{
			var iColumn = -1;
			
			for ( var i=0 ; i<oSettings.aoColumns.length ; i++ )
			{
				if ( oSettings.aoColumns[i].bVisible === true )
				{
					iColumn++;
				}
				
				if ( iColumn == iMatch )
				{
					return i;
				}
			}
			
			return null;
		}
		
		/*
		 * Function: _fnColumnIndexToVisible
		 * Purpose:  Covert the index of an index in the data array and convert it to the visible
		 *   column index (take account of hidden columns)
		 * Returns:  int:i - the data index
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnColumnIndexToVisible( oSettings, iMatch )
		{
			var iVisible = -1;
			for ( var i=0 ; i<oSettings.aoColumns.length ; i++ )
			{
				if ( oSettings.aoColumns[i].bVisible === true )
				{
					iVisible++;
				}
				
				if ( i == iMatch )
				{
					return oSettings.aoColumns[i].bVisible === true ? iVisible : null;
				}
			}
			
			return null;
		}
		
		
		/*
		 * Function: _fnNodeToDataIndex
		 * Purpose:  Take a TR element and convert it to an index in aoData
		 * Returns:  int:i - index if found, null if not
		 * Inputs:   object:s - dataTables settings object
		 *           node:n - the TR element to find
		 */
		function _fnNodeToDataIndex( s, n )
		{
			var i, iLen;
			
			/* Optimisation - see if the nodes which are currently visible match, since that is
			 * the most likely node to be asked for (a selector or event for example)
			 */
			for ( i=s._iDisplayStart, iLen=s._iDisplayEnd ; i<iLen ; i++ )
			{
				if ( s.aoData[ s.aiDisplay[i] ].nTr == n )
				{
					return s.aiDisplay[i];
				}
			}
			
			/* Otherwise we are in for a slog through the whole data cache */
			for ( i=0, iLen=s.aoData.length ; i<iLen ; i++ )
			{
				if ( s.aoData[i].nTr == n )
				{
					return i;
				}
			}
			return null;
		}
		
		/*
		 * Function: _fnVisbleColumns
		 * Purpose:  Get the number of visible columns
		 * Returns:  int:i - the number of visible columns
		 * Inputs:   object:oS - dataTables settings object
		 */
		function _fnVisbleColumns( oS )
		{
			var iVis = 0;
			for ( var i=0 ; i<oS.aoColumns.length ; i++ )
			{
				if ( oS.aoColumns[i].bVisible === true )
				{
					iVis++;
				}
			}
			return iVis;
		}
		
		/*
		 * Function: _fnCalculateEnd
		 * Purpose:  Rcalculate the end point based on the start point
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnCalculateEnd( oSettings )
		{
			if ( oSettings.oFeatures.bPaginate === false )
			{
				oSettings._iDisplayEnd = oSettings.aiDisplay.length;
			}
			else
			{
				/* Set the end point of the display - based on how many elements there are
				 * still to display
				 */
				if ( oSettings._iDisplayStart + oSettings._iDisplayLength > oSettings.aiDisplay.length ||
					   oSettings._iDisplayLength == -1 )
				{
					oSettings._iDisplayEnd = oSettings.aiDisplay.length;
				}
				else
				{
					oSettings._iDisplayEnd = oSettings._iDisplayStart + oSettings._iDisplayLength;
				}
			}
		}
		
		/*
		 * Function: _fnConvertToWidth
		 * Purpose:  Convert a CSS unit width to pixels (e.g. 2em)
		 * Returns:  int:iWidth - width in pixels
		 * Inputs:   string:sWidth - width to be converted
		 *           node:nParent - parent to get the with for (required for
		 *             relative widths) - optional
		 */
		function _fnConvertToWidth ( sWidth, nParent )
		{
			if ( !sWidth || sWidth === null || sWidth === '' )
			{
				return 0;
			}
			
			if ( typeof nParent == "undefined" )
			{
				nParent = document.getElementsByTagName('body')[0];
			}
			
			var iWidth;
			var nTmp = document.createElement( "div" );
			nTmp.style.width = sWidth;
			
			nParent.appendChild( nTmp );
			iWidth = nTmp.offsetWidth;
			nParent.removeChild( nTmp );
			
			return ( iWidth );
		}
		
		/*
		 * Function: _fnCalculateColumnWidths
		 * Purpose:  Calculate the width of columns for the table
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnCalculateColumnWidths ( oSettings )
		{
			var iTableWidth = oSettings.nTable.offsetWidth;
			var iUserInputs = 0;
			var iTmpWidth;
			var iVisibleColumns = 0;
			var iColums = oSettings.aoColumns.length;
			var i;
			var oHeaders = $('th', oSettings.nTHead);
			
			/* Convert any user input sizes into pixel sizes */
			for ( i=0 ; i<iColums ; i++ )
			{
				if ( oSettings.aoColumns[i].bVisible )
				{
					iVisibleColumns++;
					
					if ( oSettings.aoColumns[i].sWidth !== null )
					{
						iTmpWidth = _fnConvertToWidth( oSettings.aoColumns[i].sWidthOrig, 
							oSettings.nTable.parentNode );
						if ( iTmpWidth !== null )
						{
							oSettings.aoColumns[i].sWidth = _fnStringToCss( iTmpWidth );
						}
							
						iUserInputs++;
					}
				}
			}
			
			/* If the number of columns in the DOM equals the number that we have to process in 
			 * DataTables, then we can use the offsets that are created by the web-browser. No custom 
			 * sizes can be set in order for this to happen, nor scrolling used
			 */
			if ( iColums == oHeaders.length && iUserInputs === 0 && iVisibleColumns == iColums &&
				oSettings.oScroll.sX === "" && oSettings.oScroll.sY === "" )
			{
				for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
				{
					iTmpWidth = $(oHeaders[i]).width();
					if ( iTmpWidth !== null )
					{
						oSettings.aoColumns[i].sWidth = _fnStringToCss( iTmpWidth );
					}
				}
			}
			else
			{
				/* Otherwise we are going to have to do some calculations to get the width of each column.
				 * Construct a 1 row table with the widest node in the data, and any user defined widths,
				 * then insert it into the DOM and allow the browser to do all the hard work of
				 * calculating table widths.
				 */
				var
					nCalcTmp = oSettings.nTable.cloneNode( false ),
					nBody = document.createElement( 'tbody' ),
					nTr = document.createElement( 'tr' ),
					nDivSizing;
				
				nCalcTmp.removeAttribute( "id" );
				nCalcTmp.appendChild( oSettings.nTHead.cloneNode(true) );
				if ( oSettings.nTFoot !== null )
				{
					nCalcTmp.appendChild( oSettings.nTFoot.cloneNode(true) );
					_fnApplyToChildren( function(n) {
						n.style.width = "";
					}, nCalcTmp.getElementsByTagName('tr') );
				}
				
				nCalcTmp.appendChild( nBody );
				nBody.appendChild( nTr );
				
				/* Remove any sizing that was previously applied by the styles */
				var jqColSizing = $('thead th', nCalcTmp);
				if ( jqColSizing.length === 0 )
				{
					jqColSizing = $('tbody tr:eq(0)>td', nCalcTmp);
				}
				jqColSizing.each( function (i) {
					this.style.width = "";
					
					var iIndex = _fnVisibleToColumnIndex( oSettings, i );
					if ( iIndex !== null && oSettings.aoColumns[iIndex].sWidthOrig !== "" )
					{
						this.style.width = oSettings.aoColumns[iIndex].sWidthOrig;
					}
				} );
				
				/* Find the biggest td for each column and put it into the table */
				for ( i=0 ; i<iColums ; i++ )
				{
					if ( oSettings.aoColumns[i].bVisible )
					{
						var nTd = _fnGetWidestNode( oSettings, i );
						if ( nTd !== null )
						{
							nTd = nTd.cloneNode(true);
							nTr.appendChild( nTd );
						}
					}
				}
				
				/* Build the table and 'display' it */
				var nWrapper = oSettings.nTable.parentNode;
				nWrapper.appendChild( nCalcTmp );
				
				/* When scrolling (X or Y) we want to set the width of the table as appropriate. However,
				 * when not scrolling leave the table width as it is. This results in slightly different,
				 * but I think correct behaviour
				 */
				if ( oSettings.oScroll.sX !== "" && oSettings.oScroll.sXInner !== "" )
				{
					nCalcTmp.style.width = _fnStringToCss(oSettings.oScroll.sXInner);
				}
				else if ( oSettings.oScroll.sX !== "" )
				{
					nCalcTmp.style.width = "";
					if ( $(nCalcTmp).width() < nWrapper.offsetWidth )
					{
						nCalcTmp.style.width = _fnStringToCss( nWrapper.offsetWidth );
					}
				}
				else if ( oSettings.oScroll.sY !== "" )
				{
					nCalcTmp.style.width = _fnStringToCss( nWrapper.offsetWidth );
				}
				nCalcTmp.style.visibility = "hidden";
				
				/* Scrolling considerations */
				_fnScrollingWidthAdjust( oSettings, nCalcTmp );
				
				/* Read the width's calculated by the browser and store them for use by the caller. We
				 * first of all try to use the elements in the body, but it is possible that there are
				 * no elements there, under which circumstances we use the header elements
				 */
				var oNodes = $("tbody tr:eq(0)>td", nCalcTmp);
				if ( oNodes.length === 0 )
				{
					oNodes = $("thead tr:eq(0)>th", nCalcTmp);
				}
				
				var iIndex, iCorrector = 0, iWidth;
				for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
				{
					if ( oSettings.aoColumns[i].bVisible )
					{
						iWidth = $(oNodes[iCorrector]).width();
						if ( iWidth !== null && iWidth > 0 )
						{
							oSettings.aoColumns[i].sWidth = _fnStringToCss( iWidth );
						}
						iCorrector++;
					}
				}
				
				oSettings.nTable.style.width = _fnStringToCss( $(nCalcTmp).outerWidth() );
				nCalcTmp.parentNode.removeChild( nCalcTmp );
			}
		}
		
		/*
		 * Function: _fnScrollingWidthAdjust
		 * Purpose:  Adjust a table's width to take account of scrolling
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           node:n - table node
		 */
		function _fnScrollingWidthAdjust ( oSettings, n )
		{
			if ( oSettings.oScroll.sX === "" && oSettings.oScroll.sY !== "" )
			{
				/* When y-scrolling only, we want to remove the width of the scroll bar so the table
				 * + scroll bar will fit into the area avaialble.
				 */
				var iOrigWidth = $(n).width();
				n.style.width = _fnStringToCss( $(n).outerWidth()-oSettings.oScroll.iBarWidth );
			}
			else if ( oSettings.oScroll.sX !== "" )
			{
				/* When x-scrolling both ways, fix the table at it's current size, without adjusting */
				n.style.width = _fnStringToCss( $(n).outerWidth() );
			}
		}
		
		/*
		 * Function: _fnGetWidestNode
		 * Purpose:  Get the widest node
		 * Returns:  string: - max strlens for each column
		 * Inputs:   object:oSettings - dataTables settings object
		 *           int:iCol - column of interest
		 *           boolean:bFast - Should we use fast (but non-accurate) calculation - optional,
		 *             default true
		 * Notes:    This operation is _expensive_ (!!!). It requires a lot of DOM interaction, but
		 *   this is the only way to reliably get the widest string. For example 'mmm' would be wider
		 *   than 'iiii' so we can't just ocunt characters. If this can be optimised it would be good
		 *   to do so!
		 */
		function _fnGetWidestNode( oSettings, iCol, bFast )
		{
			/* Use fast not non-accurate calculate based on the strlen */
			if ( typeof bFast == 'undefined' || bFast )
			{
				var iMaxLen = _fnGetMaxLenString( oSettings, iCol );
				var iFastVis = _fnColumnIndexToVisible( oSettings, iCol);
				if ( iMaxLen < 0 )
				{
					return null;
				}
				return oSettings.aoData[iMaxLen].nTr.getElementsByTagName('td')[iFastVis];
			}
			
			/* Use the slow approach, but get high quality answers - note that this code is not actually
			 * used by DataTables by default. If you want to use it you can alter the call to 
			 * _fnGetWidestNode to pass 'false' as the third argument
			 */
			var
				iMax = -1, i, iLen,
				iMaxIndex = -1,
				n = document.createElement('div');
			
			n.style.visibility = "hidden";
			n.style.position = "absolute";
			document.body.appendChild( n );
			
			for ( i=0, iLen=oSettings.aoData.length ; i<iLen ; i++ )
			{
				n.innerHTML = oSettings.aoData[i]._aData[iCol];
				if ( n.offsetWidth > iMax )
				{
					iMax = n.offsetWidth;
					iMaxIndex = i;
				}
			}
			document.body.removeChild( n );
			
			if ( iMaxIndex >= 0 )
			{
				var iVis = _fnColumnIndexToVisible( oSettings, iCol);
				var nRet = oSettings.aoData[iMaxIndex].nTr.getElementsByTagName('td')[iVis];
				if ( nRet )
				{
					return nRet;
				}
			}
			return null;
		}
		
		/*
		 * Function: _fnGetMaxLenString
		 * Purpose:  Get the maximum strlen for each data column
		 * Returns:  string: - max strlens for each column
		 * Inputs:   object:oSettings - dataTables settings object
		 *           int:iCol - column of interest
		 */
		function _fnGetMaxLenString( oSettings, iCol )
		{
			var iMax = -1;
			var iMaxIndex = -1;
			
			for ( var i=0 ; i<oSettings.aoData.length ; i++ )
			{
				var s = oSettings.aoData[i]._aData[iCol];
				if ( s.length > iMax )
				{
					iMax = s.length;
					iMaxIndex = i;
				}
			}
			
			return iMaxIndex;
		}
		
		/*
		 * Function: _fnStringToCss
		 * Purpose:  Append a CSS unit (only if required) to a string
		 * Returns:  0 if match, 1 if length is different, 2 if no match
		 * Inputs:   array:aArray1 - first array
		 *           array:aArray2 - second array
		 */
		function _fnStringToCss( s )
		{
			if ( s === null )
			{
				return "0px";
			}
			
			if ( typeof s == 'number' )
			{
				if ( s < 0 )
				{
					return "0px";
				}
				return s+"px";
			}
			
			/* Check if the last character is not 0-9 */
			var c = s.charCodeAt( s.length-1 );
			if (c < 0x30 || c > 0x39)
			{
				return s;
			}
			return s+"px";
		}
		
		/*
		 * Function: _fnArrayCmp
		 * Purpose:  Compare two arrays
		 * Returns:  0 if match, 1 if length is different, 2 if no match
		 * Inputs:   array:aArray1 - first array
		 *           array:aArray2 - second array
		 */
		function _fnArrayCmp( aArray1, aArray2 )
		{
			if ( aArray1.length != aArray2.length )
			{
				return 1;
			}
			
			for ( var i=0 ; i<aArray1.length ; i++ )
			{
				if ( aArray1[i] != aArray2[i] )
				{
					return 2;
				}
			}
			
			return 0;
		}
		
		/*
		 * Function: _fnDetectType
		 * Purpose:  Get the sort type based on an input string
		 * Returns:  string: - type (defaults to 'string' if no type can be detected)
		 * Inputs:   string:sData - data we wish to know the type of
		 * Notes:    This function makes use of the DataTables plugin objct _oExt 
		 *   (.aTypes) such that new types can easily be added.
		 */
		function _fnDetectType( sData )
		{
			var aTypes = _oExt.aTypes;
			var iLen = aTypes.length;
			
			for ( var i=0 ; i<iLen ; i++ )
			{
				var sType = aTypes[i]( sData );
				if ( sType !== null )
				{
					return sType;
				}
			}
			
			return 'string';
		}
		
		/*
		 * Function: _fnSettingsFromNode
		 * Purpose:  Return the settings object for a particular table
		 * Returns:  object: Settings object - or null if not found
		 * Inputs:   node:nTable - table we are using as a dataTable
		 */
		function _fnSettingsFromNode ( nTable )
		{
			for ( var i=0 ; i<_aoSettings.length ; i++ )
			{
				if ( _aoSettings[i].nTable == nTable )
				{
					return _aoSettings[i];
				}
			}
			
			return null;
		}
		
		/*
		 * Function: _fnGetDataMaster
		 * Purpose:  Return an array with the full table data
		 * Returns:  array array:aData - Master data array
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnGetDataMaster ( oSettings )
		{
			var aData = [];
			var iLen = oSettings.aoData.length;
			for ( var i=0 ; i<iLen; i++ )
			{
				aData.push( oSettings.aoData[i]._aData );
			}
			return aData;
		}
		
		/*
		 * Function: _fnGetTrNodes
		 * Purpose:  Return an array with the TR nodes for the table
		 * Returns:  array: - TR array
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnGetTrNodes ( oSettings )
		{
			var aNodes = [];
			var iLen = oSettings.aoData.length;
			for ( var i=0 ; i<iLen ; i++ )
			{
				aNodes.push( oSettings.aoData[i].nTr );
			}
			return aNodes;
		}
		
		/*
		 * Function: _fnGetTdNodes
		 * Purpose:  Return an array with the TD nodes for the table
		 * Returns:  array: - TD array
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnGetTdNodes ( oSettings )
		{
			var nTrs = _fnGetTrNodes( oSettings );
			var nTds = [], nTd;
			var anReturn = [];
			var iCorrector;
			var iRow, iRows, iColumn, iColumns;
			
			for ( iRow=0, iRows=nTrs.length ; iRow<iRows ; iRow++ )
			{
				nTds = [];
				for ( iColumn=0, iColumns=nTrs[iRow].childNodes.length ; iColumn<iColumns ; iColumn++ )
				{
					nTd = nTrs[iRow].childNodes[iColumn];
					if ( nTd.nodeName.toUpperCase() == "TD" )
					{
						nTds.push( nTd );
					}
				}
				
				iCorrector = 0;
				for ( iColumn=0, iColumns=oSettings.aoColumns.length ; iColumn<iColumns ; iColumn++ )
				{
					if ( oSettings.aoColumns[iColumn].bVisible )
					{
						anReturn.push( nTds[iColumn-iCorrector] );
					}
					else
					{
						anReturn.push( oSettings.aoData[iRow]._anHidden[iColumn] );
						iCorrector++;
					}
				}
			}
			return anReturn;
		}
		
		/*
		 * Function: _fnEscapeRegex
		 * Purpose:  scape a string stuch that it can be used in a regular expression
		 * Returns:  string: - escaped string
		 * Inputs:   string:sVal - string to escape
		 */
		function _fnEscapeRegex ( sVal )
		{
			var acEscape = [ '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\', '$', '^' ];
		  var reReplace = new RegExp( '(\\' + acEscape.join('|\\') + ')', 'g' );
		  return sVal.replace(reReplace, '\\$1');
		}
		
		/*
		 * Function: _fnDeleteIndex
		 * Purpose:  Take an array of integers (index array) and remove a target integer (value - not 
		 *             the key!)
		 * Returns:  -
		 * Inputs:   a:array int - Index array to target
		 *           int:iTarget - value to find
		 */
		function _fnDeleteIndex( a, iTarget )
		{
			var iTargetIndex = -1;
			
			for ( var i=0, iLen=a.length ; i<iLen ; i++ )
			{
				if ( a[i] == iTarget )
				{
					iTargetIndex = i;
				}
				else if ( a[i] > iTarget )
				{
					a[i]--;
				}
			}
			
			if ( iTargetIndex != -1 )
			{
				a.splice( iTargetIndex, 1 );
			}
		}
		
		/*
		 * Function: _fnReOrderIndex
		 * Purpose:  Figure out how to reorder a display list
		 * Returns:  array int:aiReturn - index list for reordering
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnReOrderIndex ( oSettings, sColumns )
		{
			var aColumns = sColumns.split(',');
			var aiReturn = [];
			
			for ( var i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
			{
				for ( var j=0 ; j<iLen ; j++ )
				{
					if ( oSettings.aoColumns[i].sName == aColumns[j] )
					{
						aiReturn.push( j );
						break;
					}
				}
			}
			
			return aiReturn;
		}
		
		/*
		 * Function: _fnColumnOrdering
		 * Purpose:  Get the column ordering that DataTables expects
		 * Returns:  string: - comma separated list of names
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnColumnOrdering ( oSettings )
		{
			var sNames = '';
			for ( var i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
			{
				sNames += oSettings.aoColumns[i].sName+',';
			}
			if ( sNames.length == iLen )
			{
				return "";
			}
			return sNames.slice(0, -1);
		}
		
		/*
		 * Function: _fnLog
		 * Purpose:  Log an error message
		 * Returns:  -
		 * Inputs:   int:iLevel - log error messages, or display them to the user
		 *           string:sMesg - error message
		 */
		function _fnLog( oSettings, iLevel, sMesg )
		{
			var sAlert = oSettings.sTableId === "" ?
			 	"DataTables warning: " +sMesg :
			 	"DataTables warning (table id = '"+oSettings.sTableId+"'): " +sMesg;
			
			if ( iLevel === 0 )
			{
				if ( _oExt.sErrMode == 'alert' )
				{
					alert( sAlert );
				}
				else
				{
					throw sAlert;
				}
				return;
			}
			else if ( typeof console != 'undefined' && typeof console.log != 'undefined' )
			{
				console.log( sAlert );
			}
		}
		
		/*
		 * Function: _fnClearTable
		 * Purpose:  Nuke the table
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnClearTable( oSettings )
		{
			oSettings.aoData.splice( 0, oSettings.aoData.length );
			oSettings.aiDisplayMaster.splice( 0, oSettings.aiDisplayMaster.length );
			oSettings.aiDisplay.splice( 0, oSettings.aiDisplay.length );
			_fnCalculateEnd( oSettings );
		}
		
		/*
		 * Function: _fnSaveState
		 * Purpose:  Save the state of a table in a cookie such that the page can be reloaded
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 */
		function _fnSaveState ( oSettings )
		{
			if ( !oSettings.oFeatures.bStateSave || typeof oSettings.bDestroying != 'undefined' )
			{
				return;
			}
			
			/* Store the interesting variables */
			var i, iLen, sTmp;
			var sValue = "{";
			sValue += '"iCreate":'+ new Date().getTime()+',';
			sValue += '"iStart":'+ oSettings._iDisplayStart+',';
			sValue += '"iEnd":'+ oSettings._iDisplayEnd+',';
			sValue += '"iLength":'+ oSettings._iDisplayLength+',';
			sValue += '"sFilter":"'+ encodeURIComponent(oSettings.oPreviousSearch.sSearch)+'",';
			sValue += '"sFilterEsc":'+ !oSettings.oPreviousSearch.bRegex+',';
			
			sValue += '"aaSorting":[ ';
			for ( i=0 ; i<oSettings.aaSorting.length ; i++ )
			{
				sValue += '['+oSettings.aaSorting[i][0]+',"'+oSettings.aaSorting[i][1]+'"],';
			}
			sValue = sValue.substring(0, sValue.length-1);
			sValue += "],";
			
			sValue += '"aaSearchCols":[ ';
			for ( i=0 ; i<oSettings.aoPreSearchCols.length ; i++ )
			{
				sValue += '["'+encodeURIComponent(oSettings.aoPreSearchCols[i].sSearch)+
					'",'+!oSettings.aoPreSearchCols[i].bRegex+'],';
			}
			sValue = sValue.substring(0, sValue.length-1);
			sValue += "],";
			
			sValue += '"abVisCols":[ ';
			for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
			{
				sValue += oSettings.aoColumns[i].bVisible+",";
			}
			sValue = sValue.substring(0, sValue.length-1);
			sValue += "]";
			
			/* Save state from any plug-ins */
			for ( i=0, iLen=oSettings.aoStateSave.length ; i<iLen ; i++ )
			{
				sTmp = oSettings.aoStateSave[i].fn( oSettings, sValue );
				if ( sTmp !== "" )
				{
					sValue = sTmp;
				}
			}
			
			sValue += "}";
			
			_fnCreateCookie( oSettings.sCookiePrefix+oSettings.sInstance, sValue, 
				oSettings.iCookieDuration, oSettings.sCookiePrefix, oSettings.fnCookieCallback );
		}
		
		/*
		 * Function: _fnLoadState
		 * Purpose:  Attempt to load a saved table state from a cookie
		 * Returns:  -
		 * Inputs:   object:oSettings - dataTables settings object
		 *           object:oInit - DataTables init object so we can override settings
		 */
		function _fnLoadState ( oSettings, oInit )
		{
			if ( !oSettings.oFeatures.bStateSave )
			{
				return;
			}
			
			var oData, i, iLen;
			var sData = _fnReadCookie( oSettings.sCookiePrefix+oSettings.sInstance );
			if ( sData !== null && sData !== '' )
			{
				/* Try/catch the JSON eval - if it is bad then we ignore it - note that 1.7.0 and before
				 * incorrectly used single quotes for some strings - hence the replace below
				 */
				try
				{
					oData = (typeof $.parseJSON == 'function') ? 
						$.parseJSON( sData.replace(/'/g, '"') ) : eval( '('+sData+')' );
				}
				catch( e )
				{
					return;
				}
				
				/* Allow custom and plug-in manipulation functions to alter the data set which was
				 * saved, and also reject any saved state by returning false
				 */
				for ( i=0, iLen=oSettings.aoStateLoad.length ; i<iLen ; i++ )
				{
					if ( !oSettings.aoStateLoad[i].fn( oSettings, oData ) )
					{
						return;
					}
				}
				
				/* Store the saved state so it might be accessed at any time (particualrly a plug-in */
				oSettings.oLoadedState = $.extend( true, {}, oData );
				
				/* Restore key features */
				oSettings._iDisplayStart = oData.iStart;
				oSettings.iInitDisplayStart = oData.iStart;
				oSettings._iDisplayEnd = oData.iEnd;
				oSettings._iDisplayLength = oData.iLength;
				oSettings.oPreviousSearch.sSearch = decodeURIComponent(oData.sFilter);
				oSettings.aaSorting = oData.aaSorting.slice();
				oSettings.saved_aaSorting = oData.aaSorting.slice();
				
				/*
				 * Search filtering - global reference added in 1.4.1
				 * Note that we use a 'not' for the value of the regular expression indicator to maintain
				 * compatibility with pre 1.7 versions, where this was basically inverted. Added in 1.7.0
				 */
				if ( typeof oData.sFilterEsc != 'undefined' )
				{
					oSettings.oPreviousSearch.bRegex = !oData.sFilterEsc;
				}
				
				/* Column filtering - added in 1.5.0 beta 6 */
				if ( typeof oData.aaSearchCols != 'undefined' )
				{
					for ( i=0 ; i<oData.aaSearchCols.length ; i++ )
					{
						oSettings.aoPreSearchCols[i] = {
							"sSearch": decodeURIComponent(oData.aaSearchCols[i][0]),
							"bRegex": !oData.aaSearchCols[i][1]
						};
					}
				}
				
				/* Column visibility state - added in 1.5.0 beta 10 */
				if ( typeof oData.abVisCols != 'undefined' )
				{
					/* Pass back visibiliy settings to the init handler, but to do not here override
					 * the init object that the user might have passed in
					 */
					oInit.saved_aoColumns = [];
					for ( i=0 ; i<oData.abVisCols.length ; i++ )
					{
						oInit.saved_aoColumns[i] = {};
						oInit.saved_aoColumns[i].bVisible = oData.abVisCols[i];
					}
				}
			}
		}
		
		/*
		 * Function: _fnCreateCookie
		 * Purpose:  Create a new cookie with a value to store the state of a table
		 * Returns:  -
		 * Inputs:   string:sName - name of the cookie to create
		 *           string:sValue - the value the cookie should take
		 *           int:iSecs - duration of the cookie
		 *           string:sBaseName - sName is made up of the base + file name - this is the base
		 *           function:fnCallback - User definable function to modify the cookie
		 */
		function _fnCreateCookie ( sName, sValue, iSecs, sBaseName, fnCallback )
		{
			var date = new Date();
			date.setTime( date.getTime()+(iSecs*1000) );
			
			/* 
			 * Shocking but true - it would appear IE has major issues with having the path not having
			 * a trailing slash on it. We need the cookie to be available based on the path, so we
			 * have to append the file name to the cookie name. Appalling. Thanks to vex for adding the
			 * patch to use at least some of the path
			 */
			var aParts = window.location.pathname.split('/');
			var sNameFile = sName + '_' + aParts.pop().replace(/[\/:]/g,"").toLowerCase();
			var sFullCookie, oData;
			
			if ( fnCallback !== null )
			{
				oData = (typeof $.parseJSON == 'function') ? 
					$.parseJSON( sValue ) : eval( '('+sValue+')' );
				sFullCookie = fnCallback( sNameFile, oData, date.toGMTString(),
					aParts.join('/')+"/" );
			}
			else
			{
				sFullCookie = sNameFile + "=" + encodeURIComponent(sValue) +
					"; expires=" + date.toGMTString() +"; path=" + aParts.join('/')+"/";
			}
			
			/* Are we going to go over the cookie limit of 4KiB? If so, try to delete a cookies
			 * belonging to DataTables. This is FAR from bullet proof
			 */
			var sOldName="", iOldTime=9999999999999;
			var iLength = _fnReadCookie( sNameFile )!==null ? document.cookie.length : 
				sFullCookie.length + document.cookie.length;
			
			if ( iLength+10 > 4096 ) /* Magic 10 for padding */
			{
				var aCookies =document.cookie.split(';');
				for ( var i=0, iLen=aCookies.length ; i<iLen ; i++ )
				{
					if ( aCookies[i].indexOf( sBaseName ) != -1 )
					{
						/* It's a DataTables cookie, so eval it and check the time stamp */
						var aSplitCookie = aCookies[i].split('=');
						try { oData = eval( '('+decodeURIComponent(aSplitCookie[1])+')' ); }
						catch( e ) { continue; }
						
						if ( typeof oData.iCreate != 'undefined' && oData.iCreate < iOldTime )
						{
							sOldName = aSplitCookie[0];
							iOldTime = oData.iCreate;
						}
					}
				}
				
				if ( sOldName !== "" )
				{
					document.cookie = sOldName+"=; expires=Thu, 01-Jan-1970 00:00:01 GMT; path="+
						aParts.join('/') + "/";
				}
			}
			
			document.cookie = sFullCookie;
		}
		
		/*
		 * Function: _fnReadCookie
		 * Purpose:  Read an old cookie to get a cookie with an old table state
		 * Returns:  string: - contents of the cookie - or null if no cookie with that name found
		 * Inputs:   string:sName - name of the cookie to read
		 */
		function _fnReadCookie ( sName )
		{
			var
				aParts = window.location.pathname.split('/'),
				sNameEQ = sName + '_' + aParts[aParts.length-1].replace(/[\/:]/g,"").toLowerCase() + '=',
			 	sCookieContents = document.cookie.split(';');
			
			for( var i=0 ; i<sCookieContents.length ; i++ )
			{
				var c = sCookieContents[i];
				
				while (c.charAt(0)==' ')
				{
					c = c.substring(1,c.length);
				}
				
				if (c.indexOf(sNameEQ) === 0)
				{
					return decodeURIComponent( c.substring(sNameEQ.length,c.length) );
				}
			}
			return null;
		}
		
		/*
		 * Function: _fnGetUniqueThs
		 * Purpose:  Get an array of unique th elements, one for each column
		 * Returns:  array node:aReturn - list of unique ths
		 * Inputs:   node:nThead - The thead element for the table
		 */
		function _fnGetUniqueThs ( nThead )
		{
			var nTrs = nThead.getElementsByTagName('tr');
			
			/* Nice simple case */
			if ( nTrs.length == 1 )
			{
				return nTrs[0].getElementsByTagName('th');
			}
			
			/* Otherwise we need to figure out the layout array to get the nodes */
			var aLayout = [], aReturn = [];
			var ROWSPAN = 2, COLSPAN = 3, TDELEM = 4;
			var i, j, k, iLen, jLen, iColumnShifted;
			var fnShiftCol = function ( a, i, j ) {
				while ( typeof a[i][j] != 'undefined' ) {
					j++;
				}
				return j;
			};
			var fnAddRow = function ( i ) {
				if ( typeof aLayout[i] == 'undefined' ) {
					aLayout[i] = [];
				}
			};
			
			/* Calculate a layout array */
			for ( i=0, iLen=nTrs.length ; i<iLen ; i++ )
			{
				fnAddRow( i );
				var iColumn = 0;
				var nTds = [];
				
				for ( j=0, jLen=nTrs[i].childNodes.length ; j<jLen ; j++ )
				{
					if ( nTrs[i].childNodes[j].nodeName.toUpperCase() == "TD" ||
					     nTrs[i].childNodes[j].nodeName.toUpperCase() == "TH" )
					{
						nTds.push( nTrs[i].childNodes[j] );
					}
				}
				
				for ( j=0, jLen=nTds.length ; j<jLen ; j++ )
				{
					var iColspan = nTds[j].getAttribute('colspan') * 1;
					var iRowspan = nTds[j].getAttribute('rowspan') * 1;
					
					if ( !iColspan || iColspan===0 || iColspan===1 )
					{
						iColumnShifted = fnShiftCol( aLayout, i, iColumn );
						aLayout[i][iColumnShifted] = (nTds[j].nodeName.toUpperCase()=="TD") ? TDELEM : nTds[j];
						if ( iRowspan || iRowspan===0 || iRowspan===1 )
						{
							for ( k=1 ; k<iRowspan ; k++ )
							{
								fnAddRow( i+k );
								aLayout[i+k][iColumnShifted] = ROWSPAN;
							}
						}
						iColumn++;
					}
					else
					{
						iColumnShifted = fnShiftCol( aLayout, i, iColumn );
						for ( k=0 ; k<iColspan ; k++ )
						{
							aLayout[i][iColumnShifted+k] = COLSPAN;
						}
						iColumn += iColspan;
					}
				}
			}
			
			/* Convert the layout array into a node array */
			for ( i=0, iLen=aLayout.length ; i<iLen ; i++ )
			{
				for ( j=0, jLen=aLayout[i].length ; j<jLen ; j++ )
				{
					if ( typeof aLayout[i][j] == 'object' && typeof aReturn[j] == 'undefined' )
					{
						aReturn[j] = aLayout[i][j];
					}
				}
			}
			
			return aReturn;
		}
		
		/*
		 * Function: _fnScrollBarWidth
		 * Purpose:  Get the width of a scroll bar in this browser being used
		 * Returns:  int: - width in pixels
		 * Inputs:   -
		 * Notes:    All credit for this function belongs to Alexandre Gomes. Thanks for sharing!
		 *   http://www.alexandre-gomes.com/?p=115
		 */
		function _fnScrollBarWidth ()
		{  
			var inner = document.createElement('p');  
			var style = inner.style;
			style.width = "100%";  
			style.height = "200px";  
			
			var outer = document.createElement('div');  
			style = outer.style;
			style.position = "absolute";  
			style.top = "0px";  
			style.left = "0px";  
			style.visibility = "hidden";  
			style.width = "200px";  
			style.height = "150px";  
			style.overflow = "hidden";  
			outer.appendChild(inner);  
			
			document.body.appendChild(outer);  
			var w1 = inner.offsetWidth;  
			outer.style.overflow = 'scroll';  
			var w2 = inner.offsetWidth;  
			if ( w1 == w2 )
			{
				w2 = outer.clientWidth;  
			}
			
			document.body.removeChild(outer); 
			return (w1 - w2);  
		}
		
		/*
		 * Function: _fnApplyToChildren
		 * Purpose:  Apply a given function to the display child nodes of an element array (typically
		 *   TD children of TR rows
		 * Returns:  - (done by reference)
		 * Inputs:   function:fn - Method to apply to the objects
		 *           array nodes:an1 - List of elements to look through for display children
		 *           array nodes:an2 - Another list (identical structure to the first) - optional
		 */
		function _fnApplyToChildren( fn, an1, an2 )
		{
			for ( var i=0, iLen=an1.length ; i<iLen ; i++ )
			{
				for ( var j=0, jLen=an1[i].childNodes.length ; j<jLen ; j++ )
				{
					if ( an1[i].childNodes[j].nodeType == 1 )
					{
						if ( typeof an2 != 'undefined' )
						{
							fn( an1[i].childNodes[j], an2[i].childNodes[j] );
						}
						else
						{
							fn( an1[i].childNodes[j] );
						}
					}
				}
			}
		}
		
		/*
		 * Function: _fnMap
		 * Purpose:  See if a property is defined on one object, if so assign it to the other object
		 * Returns:  - (done by reference)
		 * Inputs:   object:oRet - target object
		 *           object:oSrc - source object
		 *           string:sName - property
		 *           string:sMappedName - name to map too - optional, sName used if not given
		 */
		function _fnMap( oRet, oSrc, sName, sMappedName )
		{
			if ( typeof sMappedName == 'undefined' )
			{
				sMappedName = sName;
			}
			if ( typeof oSrc[sName] != 'undefined' )
			{
				oRet[sMappedName] = oSrc[sName];
			}
		}
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - API
		 * 
		 * I'm not overly happy with this solution - I'd much rather that there was a way of getting
		 * a list of all the private functions and do what we need to dynamically - but that doesn't
		 * appear to be possible. Bonkers. A better solution would be to provide a 'bind' type object
		 * To do - bind type method in DTs 2.x.
		 */
		this.oApi._fnExternApiFunc = _fnExternApiFunc;
		this.oApi._fnInitalise = _fnInitalise;
		this.oApi._fnLanguageProcess = _fnLanguageProcess;
		this.oApi._fnAddColumn = _fnAddColumn;
		this.oApi._fnColumnOptions = _fnColumnOptions;
		this.oApi._fnAddData = _fnAddData;
		this.oApi._fnGatherData = _fnGatherData;
		this.oApi._fnDrawHead = _fnDrawHead;
		this.oApi._fnDraw = _fnDraw;
		this.oApi._fnReDraw = _fnReDraw;
		this.oApi._fnAjaxUpdate = _fnAjaxUpdate;
		this.oApi._fnAjaxUpdateDraw = _fnAjaxUpdateDraw;
		this.oApi._fnAddOptionsHtml = _fnAddOptionsHtml;
		this.oApi._fnFeatureHtmlTable = _fnFeatureHtmlTable;
		this.oApi._fnScrollDraw = _fnScrollDraw;
		this.oApi._fnAjustColumnSizing = _fnAjustColumnSizing;
		this.oApi._fnFeatureHtmlFilter = _fnFeatureHtmlFilter;
		this.oApi._fnFilterComplete = _fnFilterComplete;
		this.oApi._fnFilterCustom = _fnFilterCustom;
		this.oApi._fnFilterColumn = _fnFilterColumn;
		this.oApi._fnFilter = _fnFilter;
		this.oApi._fnBuildSearchArray = _fnBuildSearchArray;
		this.oApi._fnBuildSearchRow = _fnBuildSearchRow;
		this.oApi._fnFilterCreateSearch = _fnFilterCreateSearch;
		this.oApi._fnDataToSearch = _fnDataToSearch;
		this.oApi._fnSort = _fnSort;
		this.oApi._fnSortAttachListener = _fnSortAttachListener;
		this.oApi._fnSortingClasses = _fnSortingClasses;
		this.oApi._fnFeatureHtmlPaginate = _fnFeatureHtmlPaginate;
		this.oApi._fnPageChange = _fnPageChange;
		this.oApi._fnFeatureHtmlInfo = _fnFeatureHtmlInfo;
		this.oApi._fnUpdateInfo = _fnUpdateInfo;
		this.oApi._fnFeatureHtmlLength = _fnFeatureHtmlLength;
		this.oApi._fnFeatureHtmlProcessing = _fnFeatureHtmlProcessing;
		this.oApi._fnProcessingDisplay = _fnProcessingDisplay;
		this.oApi._fnVisibleToColumnIndex = _fnVisibleToColumnIndex;
		this.oApi._fnColumnIndexToVisible = _fnColumnIndexToVisible;
		this.oApi._fnNodeToDataIndex = _fnNodeToDataIndex;
		this.oApi._fnVisbleColumns = _fnVisbleColumns;
		this.oApi._fnCalculateEnd = _fnCalculateEnd;
		this.oApi._fnConvertToWidth = _fnConvertToWidth;
		this.oApi._fnCalculateColumnWidths = _fnCalculateColumnWidths;
		this.oApi._fnScrollingWidthAdjust = _fnScrollingWidthAdjust;
		this.oApi._fnGetWidestNode = _fnGetWidestNode;
		this.oApi._fnGetMaxLenString = _fnGetMaxLenString;
		this.oApi._fnStringToCss = _fnStringToCss;
		this.oApi._fnArrayCmp = _fnArrayCmp;
		this.oApi._fnDetectType = _fnDetectType;
		this.oApi._fnSettingsFromNode = _fnSettingsFromNode;
		this.oApi._fnGetDataMaster = _fnGetDataMaster;
		this.oApi._fnGetTrNodes = _fnGetTrNodes;
		this.oApi._fnGetTdNodes = _fnGetTdNodes;
		this.oApi._fnEscapeRegex = _fnEscapeRegex;
		this.oApi._fnDeleteIndex = _fnDeleteIndex;
		this.oApi._fnReOrderIndex = _fnReOrderIndex;
		this.oApi._fnColumnOrdering = _fnColumnOrdering;
		this.oApi._fnLog = _fnLog;
		this.oApi._fnClearTable = _fnClearTable;
		this.oApi._fnSaveState = _fnSaveState;
		this.oApi._fnLoadState = _fnLoadState;
		this.oApi._fnCreateCookie = _fnCreateCookie;
		this.oApi._fnReadCookie = _fnReadCookie;
		this.oApi._fnGetUniqueThs = _fnGetUniqueThs;
		this.oApi._fnScrollBarWidth = _fnScrollBarWidth;
		this.oApi._fnApplyToChildren = _fnApplyToChildren;
		this.oApi._fnMap = _fnMap;
		
		/**
		 * USER FUNCTIONS
		 */
		 this.oApi._fnCreateFilterSelect = function(aData){
      var r='<select class="column-filter"><option value=""></option>', i, iLen=aData.length;
      for ( i=0 ; i<iLen ; i++ )
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
      return r+'</select>';
    }
    
    /*
     * Function: fnGetColumn
     * Returns:  array string: Column elements
     * Inputs:   int: iCol - required - index of column
     */
		this.oApi._fnGetColumn = function (oSettings, iCol){
      var aiData = []
      var iLength = oSettings.oApi._fnGetDataMaster( oSettings ).length

      for(i=0; i < iLength; i++){
        aiData.include(oSettings.aoData[i]._aData[iCol].stripTags())
      }
      return aiData.sort();
    }
		/* Want to be able to reference "this" inside the this.each function */	
		var _that = this;
    this.oApi.fnAddColumnSelectFilter = function(oSettings, iCol){
      var nField = jQuery("thead tr:last th:eq("+iCol+")", oSettings.nTable)
      nField.append(oSettings.oApi._fnCreateFilterSelect(oSettings.oApi._fnGetColumn(oSettings, iCol)))
      _oExt.afnFiltering.include(function(oSettings, aData){
        var string =  jQuery("select", nField).val();
        if(string == "")
          return true;
        re = new RegExp("^"+string+"$")
        return aData[iCol].stripTags().match(re)
      })
			
      jQuery("select", nField).change(function(ev){_that.fnDraw(); })
    }
		
		/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 * Section - Constructor
		 */
		
		/* Want to be able to reference "this" inside the this.each function */
		var _that = this;
		return this.each(function()
		{
			var i=0, iLen, j, jLen, k, kLen;
			
			/* Check to see if we are re-initalising a table */
			for ( i=0, iLen=_aoSettings.length ; i<iLen ; i++ )
			{
				/* Base check on table node */
				if ( _aoSettings[i].nTable == this )
				{
					if ( typeof oInit == 'undefined' || 
					   ( typeof oInit.bRetrieve != 'undefined' && oInit.bRetrieve === true ) )
					{
						return _aoSettings[i].oInstance;
					}
					else if ( typeof oInit.bDestroy != 'undefined' && oInit.bDestroy === true )
					{
						_aoSettings[i].oInstance.fnDestroy();
						break;
					}
					else
					{
						_fnLog( _aoSettings[i], 0, "Cannot reinitialise DataTable.\n\n"+
							"To retrieve the DataTables object for this table, please pass either no arguments "+
							"to the dataTable() function, or set bRetrieve to true. Alternatively, to destory "+
							"the old table and create a new one, set bDestroy to true (note that a lot of "+
							"changes to the configuration can be made through the API which is usually much "+
							"faster)." );
						return;
					}
				}
				
				/* If the element we are initialising has the same ID as a table which was previously
				 * initialised, but the table nodes don't match (from before) then we destory the old
				 * instance by simply deleting it. This is under the assumption that the table has been
				 * destroyed by other methods. Anyone using non-id selectors will need to do this manually
				 */
				if ( _aoSettings[i].sTableId !== "" && _aoSettings[i].sTableId == this.getAttribute('id') )
				{
					_aoSettings.splice( i, 1 );
					break;
				}
			}
			
			/* Make a complete and independent copy of the settings object */
			var oSettings = new classSettings();
			_aoSettings.push( oSettings );

			
			var bInitHandedOff = false;
			var bUsePassedData = false;
			
			/* Set the id */
			var sId = this.getAttribute( 'id' );
			if ( sId !== null )
			{
				oSettings.sTableId = sId;
				oSettings.sInstance = sId;
			}
			else
			{
				oSettings.sInstance = _oExt._oExternConfig.iNextUnique ++;
			}
			
			/* Sanity check */
			if ( this.nodeName.toLowerCase() != 'table' )
			{
				_fnLog( oSettings, 0, "Attempted to initialise DataTables on a node which is not a "+
					"table: "+this.nodeName );
				return;
			}
			
			/* Store 'this' in the settings object for later retrieval */
			oSettings.oInstance = _that;
			
			/* Set the table node */
			oSettings.nTable = this;
			
			/* Bind the API functions to the settings, so we can perform actions whenever oSettings is
			 * available
			 */
			oSettings.oApi = _that.oApi;
			
			if($(this).hasClass("dt-non-paginable")){
			 oSettings.oFeatures.bPaginate = false;
			 oSettings.oFeatures.bLengthChange = false;
			}
			if($(this).hasClass("dt-unsortable")){
			 oSettings.oFeatures.bSort = false;
			}
			if($(this).hasClass("dt-non-filterable")){
			 oSettings.oFeatures.bFilter = false;
			}
			
			$("thead th", this).addClass("ui-state-default");


						

			/* State the table's width for if a destroy is called at a later time */
			oSettings.sDestroyWidth = $(this).width();
			
			/* Store the features that we have available */
			if ( typeof oInit != 'undefined' && oInit !== null )
			{
				oSettings.oInit = oInit;
				_fnMap( oSettings.oFeatures, oInit, "bPaginate" );
				_fnMap( oSettings.oFeatures, oInit, "bLengthChange" );
				_fnMap( oSettings.oFeatures, oInit, "bFilter" );
				_fnMap( oSettings.oFeatures, oInit, "bSort" );
				_fnMap( oSettings.oFeatures, oInit, "bInfo" );
				_fnMap( oSettings.oFeatures, oInit, "bProcessing" );
				_fnMap( oSettings.oFeatures, oInit, "bAutoWidth" );
				_fnMap( oSettings.oFeatures, oInit, "bSortClasses" );
				_fnMap( oSettings.oFeatures, oInit, "bServerSide" );
				_fnMap( oSettings.oScroll, oInit, "sScrollX", "sX" );
				_fnMap( oSettings.oScroll, oInit, "sScrollXInner", "sXInner" );
				_fnMap( oSettings.oScroll, oInit, "sScrollY", "sY" );
				_fnMap( oSettings.oScroll, oInit, "bScrollCollapse", "bCollapse" );
				_fnMap( oSettings.oScroll, oInit, "bScrollInfinite", "bInfinite" );
				_fnMap( oSettings.oScroll, oInit, "iScrollLoadGap", "iLoadGap" );
				_fnMap( oSettings.oScroll, oInit, "bScrollAutoCss", "bAutoCss" );
				_fnMap( oSettings, oInit, "asStripClasses" );
				_fnMap( oSettings, oInit, "fnRowCallback" );
				_fnMap( oSettings, oInit, "fnHeaderCallback" );
				_fnMap( oSettings, oInit, "fnFooterCallback" );
				_fnMap( oSettings, oInit, "fnCookieCallback" );
				_fnMap( oSettings, oInit, "fnInitComplete" );
				_fnMap( oSettings, oInit, "fnServerData" );
				_fnMap( oSettings, oInit, "fnFormatNumber" );
				_fnMap( oSettings, oInit, "aaSorting" );
				_fnMap( oSettings, oInit, "aaSortingFixed" );
				_fnMap( oSettings, oInit, "aLengthMenu" );
				_fnMap( oSettings, oInit, "sPaginationType" );
				_fnMap( oSettings, oInit, "sAjaxSource" );
				_fnMap( oSettings, oInit, "iCookieDuration" );
				_fnMap( oSettings, oInit, "sCookiePrefix" );
				_fnMap( oSettings, oInit, "sDom" );
				_fnMap( oSettings, oInit, "oSearch", "oPreviousSearch" );
				_fnMap( oSettings, oInit, "aoSearchCols", "aoPreSearchCols" );
				_fnMap( oSettings, oInit, "iDisplayLength", "_iDisplayLength" );
				_fnMap( oSettings, oInit, "bJQueryUI", "bJUI" );
				_fnMap( oSettings.oLanguage, oInit, "fnInfoCallback" );
	

				
				/* Callback functions which are array driven */
				if ( typeof oInit.fnDrawCallback == 'function' )
				{
					oSettings.aoDrawCallback.push( {
						"fn": oInit.fnDrawCallback,
						"sName": "user"
					} );
				}
				
				if ( typeof oInit.fnStateSaveCallback == 'function' )
				{
					oSettings.aoStateSave.push( {
						"fn": oInit.fnStateSaveCallback,
						"sName": "user"
					} );
				}
				
				if ( typeof oInit.fnStateLoadCallback == 'function' )
				{
					oSettings.aoStateLoad.push( {
						"fn": oInit.fnStateLoadCallback,
						"sName": "user"
					} );
				}
				
				if ( oSettings.oFeatures.bServerSide && oSettings.oFeatures.bSort &&
					   oSettings.oFeatures.bSortClasses )
				{
					/* Enable sort classes for server-side processing. Safe to do it here, since server-side
					 * processing must be enabled by the developer
					 */
					oSettings.aoDrawCallback.push( {
						"fn": _fnSortingClasses,
						"sName": "server_side_sort_classes"
					} );
				}
				
				if ( typeof oInit.bJQueryUI != 'undefined' && oInit.bJQueryUI )
				{
					/* Use the JUI classes object for display. You could clone the oStdClasses object if 
					 * you want to have multiple tables with multiple independent classes 
					 */
					oSettings.oClasses = _oExt.oJUIClasses;
					
					if ( typeof oInit.sDom == 'undefined' )
					{
						/* Set the DOM to use a layout suitable for jQuery UI's theming */
						oSettings.sDom = '<"H"Tflr>t<"F"Cip>';
					}
				}
				
				/* Calculate the scroll bar width and cache it for use later on */
				if ( oSettings.oScroll.sX !== "" || oSettings.oScroll.sY !== "" )
				{
					oSettings.oScroll.iBarWidth = _fnScrollBarWidth();
				}
				
				if ( typeof oInit.iDisplayStart != 'undefined' && 
				     typeof oSettings.iInitDisplayStart == 'undefined' )
				{
					/* Display start point, taking into account the save saving */
					oSettings.iInitDisplayStart = oInit.iDisplayStart;
					oSettings._iDisplayStart = oInit.iDisplayStart;
				}
				
				/* Must be done after everything which can be overridden by a cookie! */
				if ( typeof oInit.bStateSave != 'undefined' )
				{
					oSettings.oFeatures.bStateSave = oInit.bStateSave;
					_fnLoadState( oSettings, oInit );
					oSettings.aoDrawCallback.push( {
						"fn": _fnSaveState,
						"sName": "state_save"
					} );
				}
				
				if ( typeof oInit.aaData != 'undefined' )
				{
					bUsePassedData = true;
				}
				
				/* Backwards compatability */
				/* aoColumns / aoData - remove at some point... */
				if ( typeof oInit != 'undefined' && typeof oInit.aoData != 'undefined' )
				{
					oInit.aoColumns = oInit.aoData;
				}
				
				/* Language definitions */
				if ( typeof oInit.oLanguage != 'undefined' )
				{
					if ( typeof oInit.oLanguage.sUrl != 'undefined' && oInit.oLanguage.sUrl !== "" )
					{
						/* Get the language definitions from a file */
						oSettings.oLanguage.sUrl = oInit.oLanguage.sUrl;
						$.getJSON( oSettings.oLanguage.sUrl, null, function( json ) { 
							_fnLanguageProcess( oSettings, json, true ); } );
						bInitHandedOff = true;
					}
					else
					{
						_fnLanguageProcess( oSettings, oInit.oLanguage, false );
					}
				}
				/* Warning: The _fnLanguageProcess function is async to the remainder of this function due
				 * to the XHR. We use _bInitialised in _fnLanguageProcess() to check this the processing 
				 * below is complete. The reason for spliting it like this is optimisation - we can fire
				 * off the XHR (if needed) and then continue processing the data.
				 */
			}
			else
			{
				/* Create a dummy object for quick manipulation later on. */
				oInit = {};
			}
						
			/*
			 * Stripes
			 * Add the strip classes now that we know which classes to apply - unless overruled
			 */
			if ( typeof oInit.asStripClasses == 'undefined' )
			{
				oSettings.asStripClasses.push( oSettings.oClasses.sStripOdd );
				oSettings.asStripClasses.push( oSettings.oClasses.sStripEven );
			}
			
			/* Remove row stripe classes if they are already on the table row */
			var bStripeRemove = false;
			var anRows = $('tbody>tr', this);
			for ( i=0, iLen=oSettings.asStripClasses.length ; i<iLen ; i++ )
			{
				if ( anRows.filter(":lt(2)").hasClass( oSettings.asStripClasses[i]) )
				{
					bStripeRemove = true;
					break;
				}
			}
					
			if ( bStripeRemove )
			{
				/* Store the classes which we are about to remove so they can be readded on destory */
				oSettings.asDestoryStrips = [ '', '' ];
				if ( $(anRows[0]).hasClass(oSettings.oClasses.sStripOdd) )
				{
					oSettings.asDestoryStrips[0] += oSettings.oClasses.sStripOdd+" ";
				}
				if ( $(anRows[0]).hasClass(oSettings.oClasses.sStripEven) )
				{
					oSettings.asDestoryStrips[0] += oSettings.oClasses.sStripEven;
				}
				if ( $(anRows[1]).hasClass(oSettings.oClasses.sStripOdd) )
				{
					oSettings.asDestoryStrips[1] += oSettings.oClasses.sStripOdd+" ";
				}
				if ( $(anRows[1]).hasClass(oSettings.oClasses.sStripEven) )
				{
					oSettings.asDestoryStrips[1] += oSettings.oClasses.sStripEven;
				}
				
				anRows.removeClass( oSettings.asStripClasses.join(' ') );
			}
			
			/*
			 * Columns
			 * See if we should load columns automatically or use defined ones
			 */
			var nThead = this.getElementsByTagName('thead');
			var anThs = nThead.length===0 ? [] : _fnGetUniqueThs( nThead[0] );
			var aoColumnsInit;

			/* If not given a column array, generate one with nulls */
			if ( typeof oInit.aoColumns == 'undefined' )
			{
				aoColumnsInit = [];
				for ( i=0, iLen=anThs.length ; i<iLen ; i++ )
				{
					aoColumnsInit.push( null );
				}
			}
			else
			{
				aoColumnsInit = oInit.aoColumns;
			}
			
			/* Add the columns */
			for ( i=0, iLen=aoColumnsInit.length ; i<iLen ; i++ )
			{
				/* Check if we have column visibilty state to restore */
				if ( typeof oInit.saved_aoColumns != 'undefined' && oInit.saved_aoColumns.length == iLen )
				{
					if ( aoColumnsInit[i] === null )
					{
						aoColumnsInit[i] = {};
					}
					aoColumnsInit[i].bVisible = oInit.saved_aoColumns[i].bVisible;
				}
				
				_fnAddColumn( oSettings, anThs ? anThs[i] : null );
			}
			
			/* Add options from column definations */
			if ( typeof oInit.aoColumnDefs != 'undefined' )
			{
				/* Loop over the column defs array - loop in reverse so first instace has priority */
				for ( i=oInit.aoColumnDefs.length-1 ; i>=0 ; i-- )
				{
					/* Each column def can target multiple columns, as it is an array */
					var aTargets = oInit.aoColumnDefs[i].aTargets;
					if ( !$.isArray( aTargets ) )
					{
						_fnLog( oSettings, 1, 'aTargets must be an array of targets, not a '+(typeof aTargets) );
					}
					for ( j=0, jLen=aTargets.length ; j<jLen ; j++ )
					{
						if ( typeof aTargets[j] == 'number' && aTargets[j] >= 0 )
						{
							/* 0+ integer, left to right column counting. We add columns which are unknown
							 * automatically. Is this the right behaviour for this? We should at least
							 * log it in future. We cannot do this for the negative or class targets, only here.
							 */
							while( oSettings.aoColumns.length <= aTargets[j] )
							{
								_fnAddColumn( oSettings );
							}
							_fnColumnOptions( oSettings, aTargets[j], oInit.aoColumnDefs[i] );
						}
						else if ( typeof aTargets[j] == 'number' && aTargets[j] < 0 )
						{
							/* Negative integer, right to left column counting */
							_fnColumnOptions( oSettings, oSettings.aoColumns.length+aTargets[j], 
								oInit.aoColumnDefs[i] );
						}
						else if ( typeof aTargets[j] == 'string' )
						{
							/* Class name matching on TH element */
							for ( k=0, kLen=oSettings.aoColumns.length ; k<kLen ; k++ )
							{
								if ( aTargets[j] == "_all" ||
								     oSettings.aoColumns[k].nTh.className.indexOf( aTargets[j] ) != -1 )
								{
									_fnColumnOptions( oSettings, k, oInit.aoColumnDefs[i] );
								}
							}
						}
					}
				}
			}
			
			/* Add options from column array - after the defs array so this has priority */
			if ( typeof aoColumnsInit != 'undefined' )
			{
				for ( i=0, iLen=aoColumnsInit.length ; i<iLen ; i++ )
				{
					_fnColumnOptions( oSettings, i, aoColumnsInit[i] );
				}
			}
			
			/*
			 * Sorting
			 * Check the aaSorting array
			 */
			for ( i=0, iLen=oSettings.aaSorting.length ; i<iLen ; i++ )
			{
				if ( oSettings.aaSorting[i][0] >= oSettings.aoColumns.length )
				{
					oSettings.aaSorting[i][0] = 0;
				}
				var oColumn = oSettings.aoColumns[ oSettings.aaSorting[i][0] ];
				
				/* Add a default sorting index */
				if ( typeof oSettings.aaSorting[i][2] == 'undefined' )
				{
					oSettings.aaSorting[i][2] = 0;
				}
				
				/* If aaSorting is not defined, then we use the first indicator in asSorting */
				if ( typeof oInit.aaSorting == "undefined" && 
						 typeof oSettings.saved_aaSorting == "undefined" )
				{
					oSettings.aaSorting[i][1] = oColumn.asSorting[0];
				}
				
				/* Set the current sorting index based on aoColumns.asSorting */
				for ( j=0, jLen=oColumn.asSorting.length ; j<jLen ; j++ )
				{
					if ( oSettings.aaSorting[i][1] == oColumn.asSorting[j] )
					{
						oSettings.aaSorting[i][2] = j;
						break;
					}
				}
			}
				
			/* Do a first pass on the sorting classes (allows any size changes to be taken into
			 * account, and also will apply sorting disabled classes if disabled
			 */
			_fnSortingClasses( oSettings );
			
			/*
			 * Final init
			 * Sanity check that there is a thead and tbody. If not let's just create them
			 */
			if ( this.getElementsByTagName('thead').length === 0 )
			{
				this.appendChild( document.createElement( 'thead' ) );
			}
			
			if ( this.getElementsByTagName('tbody').length === 0 )
			{
				this.appendChild( document.createElement( 'tbody' ) );
			}
			
			oSettings.nTHead = this.getElementsByTagName('thead')[0];
			oSettings.nTBody = this.getElementsByTagName('tbody')[0];
			if ( this.getElementsByTagName('tfoot').length > 0 )
			{
				oSettings.nTFoot = this.getElementsByTagName('tfoot')[0];
			}
			
			/* Check if there is data passing into the constructor */
			if ( bUsePassedData )
			{
				for ( i=0 ; i<oInit.aaData.length ; i++ )
				{
					_fnAddData( oSettings, oInit.aaData[ i ] );
				}
			}
			else
			{
				/* Grab the data from the page */
				_fnGatherData( oSettings );
			}
			
			/* Copy the data index array */
			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			
			/* Initialisation complete - table can be drawn */
			oSettings.bInitialised = true;
			
			/* Check if we need to initialise the table (it might not have been handed off to the
			 * language processor)
			 */
			if ( bInitHandedOff === false )
			{
				_fnInitalise( oSettings );
			}
		});
	};
})(jQuery, window, document);


function DT_group_rows(oSettings){
	if ( oSettings.aiDisplay.length == 0 ){
		return;
	}
	var nTrs = $('tbody tr', oSettings.nTable);
	var iColspan = nTrs[0].getElementsByTagName('td').length;
	var sLastGroup = "";
	for ( var i=0 ; i<nTrs.length ; i++ ){
		var iDisplayIndex = oSettings._iDisplayStart + i;
		var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[0];
		if ( sGroup != sLastGroup ){
			var nGroup = document.createElement( 'tr' );
			var nCell = document.createElement( 'td' );
			nCell.colSpan = iColspan;
			nCell.className = "dt-grouped-cell ui-widget-header";
			nCell.innerHTML = sGroup;
			nGroup.appendChild( nCell );
			nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
			sLastGroup = sGroup;
		}
	}
}

(function($) {

/** 
 * ColVis provides column visiblity control for DataTables
 * @class ColVis
 * @constructor
 * @param {object} DataTables settings object
 */
ColVis = function( oDTSettings )
{
	/* Santiy check that we are a new instance */
	if ( !this.CLASS || this.CLASS != "ColVis" )
	{
		alert( "Warning: ColVis must be initialised with the keyword 'new'" );
	}
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public class variables
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/**
	 * @namespace Settings object which contains customisable information for ColVis instance
	 */
	this.s = {
		/**
		 * DataTables settings object
		 *  @property dt
		 *  @type     Object
		 *  @default  null
		 */
		"dt": null,
		
		/**
		 * Mode of activation. Can be 'click' or 'mouseover'
		 *  @property activate
		 *  @type     String
		 *  @default  click
		 */
		"activate": "click",
		
		/**
		 * Text used for the button
		 *  @property buttonText
		 *  @type     String
		 *  @default  Show / hide columns
		 */
		"buttonText": "<span class='ui-icon nuvola-icon ui-nuvola-eye' title='Visibilidad'></span>",
		
		/**
		 * Flag to say if the collection is hidden
		 *  @property hidden
		 *  @type     boolean
		 *  @default  true
		 */
		"hidden": true,
		
		/**
		 * List of columns (integers) which should be excluded from the list
		 *  @property aiExclude
		 *  @type     Array
		 *  @default  []
		 */
		"aiExclude": []
	};
	
	
	/**
	 * @namespace Common and useful DOM elements for the class instance
	 */
	this.dom = {
		/**
		 * Wrapper for the button - given back to DataTables as the node to insert
		 *  @property wrapper
		 *  @type     Node
		 *  @default  null
		 */
		"wrapper": null,
		
		/**
		 * Activation button
		 *  @property button
		 *  @type     Node
		 *  @default  null
		 */
		"button": null,
		
		/**
		 * Collection list node
		 *  @property collection
		 *  @type     Node
		 *  @default  null
		 */
		"collection": null,
		
		/**
		 * Background node used for shading the display and event capturing
		 *  @property background
		 *  @type     Node
		 *  @default  null
		 */
		"background": null,
		
		/**
		 * Element to position over the activation button to catch mouse events when using mouseover
		 *  @property catcher
		 *  @type     Node
		 *  @default  null
		 */
		"catcher": null,
		
		/**
		 * List of button elements
		 *  @property buttons
		 *  @type     Array
		 *  @default  []
		 */
		"buttons": []
	};
	
	
	
	
	
	/* Constructor logic */
	this.s.dt = oDTSettings;
	this._fnConstruct();
	return this;
};



ColVis.prototype = {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods (they are of course public in JS, but recommended as private)
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/**
	 * Constructor logic
	 *  @method  _fnConstruct
	 *  @returns void
	 *  @private 
	 */
	"_fnConstruct": function ()
	{
		this._fnApplyCustomisation();
		
		var that = this;
		this.dom.wrapper = document.createElement('div');
		this.dom.wrapper.className = "ColVis TableTools";
		
		this.dom.button = this._fnDomBaseButton( this.s.buttonText );
		this.dom.wrapper.appendChild( this.dom.button );
		
		this.dom.catcher = this._fnDomCatcher();
		this.dom.collection = this._fnDomCollection();
		this.dom.background = this._fnDomBackground();
		
		this._fnAddButtons();
		
		this.s.dt.aoDrawCallback.push( {
			"fn": function () {
				that._fnDrawCallback.call( that );
			},
			"sName": "ColVis"
		} );
	},
	
	
	/**
	 * Apply any customisation to the settings from the DataTables initialisation
	 *  @method  _fnApplyCustomisation
	 *  @returns void
	 *  @private 
	 */
	"_fnApplyCustomisation": function ()
	{

		if ( this.s.dt.oInit != null && typeof this.s.dt.oInit.oColVis != 'undefined' )
		{
			var oConfig = this.s.dt.oInit.oColVis;
			
			if ( typeof oConfig.activate != 'undefined' )
			{
				this.s.activate = oConfig.activate;
			}
			
			if ( typeof oConfig.buttonText != 'undefined' )
			{
				this.s.buttonText = oConfig.buttonText;
			}
			
			if ( typeof oConfig.aiExclude != 'undefined' )
			{
				this.s.aiExclude = oConfig.aiExclude;
			}
		}
	},
	
	
	/**
	 * On each table draw, check the visiblity checkboxes as needed. This allows any process to
	 * update the table's column visiblity and ColVis will still be accurate.
	 *  @method  _fnDrawCallback
	 *  @returns void
	 *  @private 
	 */
	"_fnDrawCallback": function ()
	{
		var aoColumns = this.s.dt.aoColumns;
		
		for ( var i=0, iLen=aoColumns.length ; i<iLen ; i++ )
		{
			if ( this.dom.buttons[i] !== null )
			{
				if ( aoColumns[i].bVisible )
				{
					$('input', this.dom.buttons[i]).attr('checked','checked');
				}
				else
				{
					$('input', this.dom.buttons[i]).removeAttr('checked');
				}
			}
		}
	},
	
	
	/**
	 * Loop through the columns in the table and as a new button for each one.
	 *  @method  _fnAddButtons
	 *  @returns void
	 *  @private 
	 */
	"_fnAddButtons": function ()
	{
		var
			nButton,
			sExclude = ","+this.s.aiExclude.join(',')+",";
		
		for ( var i=0, iLen=this.s.dt.aoColumns.length ; i<iLen ; i++ )
		{
			if ( sExclude.indexOf( ","+i+"," ) == -1 )
			{
				nButton = this._fnDomColumnButton( i );
				this.dom.buttons.push( nButton );
				this.dom.collection.appendChild( nButton );
			}
			else
			{
				this.dom.buttons.push( null );
			}
		}
	},
	
	
	/**
	 * Create the DOM for a show / hide button
	 *  @method  _fnDomColumnButton
	 *  @param {int} i Column in question
	 *  @returns {Node} Created button
	 *  @private 
	 */
	"_fnDomColumnButton": function ( i )
	{
		var
			that = this,
			oColumn = this.s.dt.aoColumns[i],
		  nButton = document.createElement('button'),
		  nSpan = document.createElement('span');
		
		nButton.className = !this.s.dt.bJUI ? "ColVis_Button TableTools_Button" :
			"ColVis_Button TableTools_Button";
		nButton.appendChild( nSpan );
		$(nSpan).html(
			'<span class="ColVis_radio"><input type="checkbox"></span>'+
			'<span class="ColVis_title">'+oColumn.sTitle+'</span>' );
		
		$(nButton).click( function (e) {
			var showHide = $('input',this).attr('checked')===true ? false : true;
			if ( e.target.nodeName.toLowerCase() == "input" )
			{
				showHide = $('input',this).attr('checked');
			}
			that.s.dt.oInstance.fnSetColumnVis( i, showHide );
		} );
		
		return nButton;
	},
	
	
	/**
	 * Create the DOM needed for the button and apply some base properties. All buttons start here
	 *  @method  _fnDomBaseButton
	 *  @param   {String} text Button text
	 *  @returns {Node} DIV element for the button
	 *  @private 
	 */
	"_fnDomBaseButton": function ( text )
	{
		var
			that = this,
		  nButton = document.createElement('button'),
		  nSpan = document.createElement('span'),
			sEvent = this.s.activate=="mouseover" ? "mouseover" : "click";
		
		nButton.className = !this.s.dt.bJUI ? "ColVis_Button TableTools_Button" :
			"ColVis_Button TableTools_Button ui-button";
		nButton.appendChild( nSpan );
		nSpan.innerHTML = text;
		
		$(nButton).bind( sEvent, function (e) {
			that._fnCollectionShow();
			e.preventDefault();
		} );
		
		return nButton;
	},
	
	
	/**
	 * Create the element used to contain list the columns (it is shown and hidden as needed)
	 *  @method  _fnDomCollection
	 *  @returns {Node} div container for the collection
	 *  @private 
	 */
	"_fnDomCollection": function ()
	{
		var that = this;
		var nHidden = document.createElement('div');
		nHidden.style.display = "none";
		nHidden.className = !this.s.dt.bJUI ? "ColVis_collection TableTools_collection" :
			"ColVis_collection TableTools_collection ui-buttonset ui-buttonset-multi";
		nHidden.style.position = "absolute";
		$(nHidden).css('opacity', 0);
		
		return nHidden;
	},
	
	
	/**
	 * An element to be placed on top of the activate button to catch events
	 *  @method  _fnDomCatcher
	 *  @returns {Node} div container for the collection
	 *  @private 
	 */
	"_fnDomCatcher": function ()
	{
		var 
			that = this,
			nCatcher = document.createElement('div');
		nCatcher.className = "ColVis_catcher TableTools_catcher";
		
		$(nCatcher).click( function () {
			that._fnCollectionHide.call( that, null, null );
		} );
		
		return nCatcher;
	},
	
	
	/**
	 * Create the element used to shade the background, and capture hide events (it is shown and 
	 * hidden as needed)
	 *  @method  _fnDomBackground
	 *  @returns {Node} div container for the background
	 *  @private 
	 */
	"_fnDomBackground": function ()
	{
		var that = this;
		
		var nBackground = document.createElement('div');
		nBackground.className = "TableTools_collectionBackground";
		$(nBackground).css('opacity', 0);
		
		$(nBackground).click( function () {
			that._fnCollectionHide.call( that, null, null );
		} );
		
		/* When considering a mouse over action for the activation, we also consider a mouse out
		 * which is the same as a mouse over the background - without all the messing around of
		 * bubbling events. Use the catcher element to avoid messing around with bubbling
		 */
		if ( this.s.activate == "mouseover" )
		{
			$(nBackground).mouseover( function () {
				that.s.overcollection = false;
				that._fnCollectionHide.call( that, null, null );
			} );
		}
		
		return nBackground;
	},
	
	
	/**
	 * Show the show / hide list and the background
	 *  @method  _fnCollectionShow
	 *  @returns void
	 *  @private 
	 */
	"_fnCollectionShow": function ()
	{
		var that = this;
		var oPos = $(this.dom.button).offset();
		var nHidden = this.dom.collection;
		var nBackground = this.dom.background;
		var iDivX = parseInt(oPos.left, 10);
		var iDivY = parseInt(oPos.top + $(this.dom.button).outerHeight(), 10);
		
		nHidden.style.left = iDivX+"px";
		nHidden.style.top = iDivY+"px";
		nHidden.style.display = "block";
		$(nHidden).css('opacity',0);
		
		var iWinHeight = $(window).height(), iDocHeight = $(document).height(),
		 	iWinWidth = $(window).width(), iDocWidth = $(document).width();
		
		nBackground.style.height = ((iWinHeight>iDocHeight)? iWinHeight : iDocHeight) +"px";
		nBackground.style.width = ((iWinWidth<iDocWidth)? iWinWidth : iDocWidth) +"px";
		
		var oStyle = this.dom.catcher.style;
		oStyle.height = $(this.dom.button).outerHeight()+"px";
		oStyle.width = $(this.dom.button).outerWidth()+"px";
		oStyle.top = oPos.top+"px";
		oStyle.left = iDivX+"px";
		
		document.body.appendChild( nBackground );
		document.body.appendChild( nHidden );
		document.body.appendChild( this.dom.catcher );
		
		/* Visual corrections to try and keep the collection visible */
		var iDivWidth = $(nHidden).outerWidth();
		var iDivHeight = $(nHidden).outerHeight();
		
		if ( iDivX + iDivWidth > iDocWidth )
		{
			nHidden.style.left = (iDocWidth-iDivWidth)+"px";
		}
		
		/*if ( iDivY + iDivHeight > iDocHeight )
		{
			nHidden.style.top = (iDivY-iDivHeight-$(nButton).outerHeight())+"px";
		}*/
		
		
		/* This results in a very small delay for the end user but it allows the animation to be
		 * much smoother. If you don't want the animation, then the setTimeout can be removed
		 */
		setTimeout( function () {
			$(nHidden).animate({"opacity": 1}, 500);
			$(nBackground).animate({"opacity": 0.1}, 500);
		}, 10 );
		
		this.s.hidden = false;
	},
	
	
	/**
	 * Hide the show / hide list and the background
	 *  @method  _fnCollectionHide
	 *  @returns void
	 *  @private 
	 */
	"_fnCollectionHide": function (  )
	{
		var that = this;
		
		if ( !this.s.hidden && this.dom.collection !== null )
		{
			this.s.hidden = true;
			
			$(this.dom.collection).animate({"opacity": 0}, 500, function (e) {
				this.style.display = "none";
			} );
			
			$(this.dom.background).animate({"opacity": 0}, 500, function (e) {
				document.body.removeChild( that.dom.background );
				document.body.removeChild( that.dom.catcher );
			} );
		}
	}
};





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Constants
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Name of this class
 *  @constant CLASS
 *  @type     String
 *  @default  ColVis
 */
ColVis.prototype.CLASS = "ColVis";


/**
 * ColVis version
 *  @constant  VERSION
 *  @type      String
 *  @default   1.0.0
 */
ColVis.VERSION = "1.0.1";
ColVis.prototype.VERSION = ColVis.VERSION;





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Initialisation
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/*
 * Register a new feature with DataTables
 */
if ( typeof $.fn.dataTable == "function" &&
     typeof $.fn.dataTableExt.fnVersionCheck == "function" &&
     $.fn.dataTableExt.fnVersionCheck('1.7.0') )
{
	$.fn.dataTableExt.aoFeatures.push( {
		"fnInit": function( oDTSettings ) {
			var tt = new ColVis( oDTSettings );
			return tt.dom.wrapper;
		},
		"cFeature": "C",
		"sFeature": "ColVis"
	} );
}
else
{
	alert( "Warning: ColVis requires DataTables 1.7 or greater - www.datatables.net/download");
}
})(jQuery);


var ZeroClipboard = {
	
	version: "1.0.4-mod",
	clients: {}, // registered upload clients on page, indexed by id
	moviePath: 'ZeroClipboard.swf', // URL to movie
	nextId: 1, // ID of next movie
	
	$: function(thingy) {
		// simple DOM lookup utility function
		if (typeof(thingy) == 'string') thingy = document.getElementById(thingy);
		if (!thingy.addClass) {
			// extend element with a few useful methods
			thingy.hide = function() { this.style.display = 'none'; };
			thingy.show = function() { this.style.display = ''; };
			thingy.addClass = function(name) { this.removeClass(name); this.className += ' ' + name; };
			thingy.removeClass = function(name) {
				this.className = this.className.replace( new RegExp("\\s*" + name + "\\s*"), " ").replace(/^\s+/, '').replace(/\s+$/, '');
			};
			thingy.hasClass = function(name) {
				return !!this.className.match( new RegExp("\\s*" + name + "\\s*") );
			}
		}
		return thingy;
	},
	
	setMoviePath: function(path) {
		// set path to ZeroClipboard.swf
		this.moviePath = path;
	},
	
	dispatch: function(id, eventName, args) {
		// receive event from flash movie, send to client		
		var client = this.clients[id];
		if (client) {
			client.receiveEvent(eventName, args);
		}
	},
	
	register: function(id, client) {
		// register new client to receive events
		this.clients[id] = client;
	},
	
	getDOMObjectPosition: function(obj) {
		// get absolute coordinates for dom element
		var info = {
			left: 0, 
			top: 0, 
			width: obj.width ? obj.width : obj.offsetWidth, 
			height: obj.height ? obj.height : obj.offsetHeight
		};
		
		if ( obj.style.width != "" )
			info.width = obj.style.width.replace("px","");
		
		if ( obj.style.height != "" )
			info.height = obj.style.height.replace("px","");

		while (obj) {
			info.left += obj.offsetLeft;
			info.top += obj.offsetTop;
			obj = obj.offsetParent;
		}

		return info;
	},
	
	Client: function(elem) {
		// constructor for new simple upload client
		this.handlers = {};
		
		// unique ID
		this.id = ZeroClipboard.nextId++;
		this.movieId = 'ZeroClipboardMovie_' + this.id;
		
		// register client with singleton to receive flash events
		ZeroClipboard.register(this.id, this);
		
		// create movie
		if (elem) this.glue(elem);
	}
};

ZeroClipboard.Client.prototype = {
	
	id: 0, // unique ID for us
	ready: false, // whether movie is ready to receive events or not
	movie: null, // reference to movie object
	clipText: '', // text to copy to clipboard
	fileName: '', // default file save name
	action: 'copy', // action to perform
	handCursorEnabled: true, // whether to show hand cursor, or default pointer cursor
	cssEffects: true, // enable CSS mouse effects on dom container
	handlers: null, // user event handlers
	
	glue: function(elem, title) {
		// glue to DOM element
		// elem can be ID or actual DOM element object
		this.domElement = ZeroClipboard.$(elem);
		
		// float just above object, or zIndex 99 if dom element isn't set
		var zIndex = 99;
		if (this.domElement.style.zIndex) {
			zIndex = parseInt(this.domElement.style.zIndex) + 1;
		}
		
		// find X/Y position of domElement
		var box = ZeroClipboard.getDOMObjectPosition(this.domElement);
		
		// create floating DIV above element
		this.div = document.createElement('div');
		var style = this.div.style;
		style.width = '' + box.width + 'px';
		style.height = '' + box.height + 'px';
		style.zIndex = zIndex;
		if ( typeof title != "undefined" ) {
			this.div.title = title;
		}
		
		// style.backgroundColor = '#f00'; // debug
		this.domElement.appendChild(this.div);
		
		this.div.innerHTML = this.getHTML( box.width, box.height );
	},
	
	getHTML: function(width, height) {
		// return HTML for movie
		var html = '';
		var flashvars = 'id=' + this.id + 
			'&width=' + width + 
			'&height=' + height;
			
		if (navigator.userAgent.match(/MSIE/)) {
			// IE gets an OBJECT tag
			var protocol = location.href.match(/^https/i) ? 'https://' : 'http://';
			html += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="'+protocol+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="'+width+'" height="'+height+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><param name="wmode" value="transparent"/></object>';
		}
		else {
			// all other browsers get an EMBED tag
			html += '<embed id="'+this.movieId+'" src="'+ZeroClipboard.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+width+'" height="'+height+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'" wmode="transparent" />';
		}
		return html;
	},
	
	hide: function() {
		// temporarily hide floater offscreen
		if (this.div) {
			this.div.style.left = '-2000px';
		}
	},
	
	show: function() {
		// show ourselves after a call to hide()
		this.reposition();
	},
	
	destroy: function() {
		// destroy control and floater
		if (this.domElement && this.div) {
			this.hide();
			this.div.innerHTML = '';
			
			var body = document.getElementsByTagName('body')[0];
			try { body.removeChild( this.div ); } catch(e) {;}
			
			this.domElement = null;
			this.div = null;
		}
	},
	
	reposition: function(elem) {
		// reposition our floating div, optionally to new container
		// warning: container CANNOT change size, only position
		if (elem) {
			this.domElement = ZeroClipboard.$(elem);
			if (!this.domElement) this.hide();
		}
		
		if (this.domElement && this.div) {
			var box = ZeroClipboard.getDOMObjectPosition(this.domElement);
			var style = this.div.style;
			style.left = '' + box.left + 'px';
			style.top = '' + box.top + 'px';
		}
	},
	
	clearText: function() {
		// clear the text to be copy / saved
		this.clipText = '';
		if (this.ready) this.movie.clearText();
	},
	
	appendText: function(newText) {
		// append text to that which is to be copied / saved
		this.clipText += newText;
		if (this.ready) { this.movie.appendText(newText) ;}
	},
	
	setText: function(newText) {
		// set text to be copied to be copied / saved
		this.clipText = newText;
		if (this.ready) { this.movie.setText(newText) ;}
	},
	
	setCharSet: function(charSet) {
		// set the character set (UTF16LE or UTF8)
		this.charSet = charSet;
		if (this.ready) { this.movie.setCharSet(charSet) ;}
	},
	
	setBomInc: function(bomInc) {
		// set if the BOM should be included or not
		this.incBom = bomInc;
		if (this.ready) { this.movie.setBomInc(bomInc) ;}
	},
	
	setFileName: function(newText) {
		// set the file name
		this.fileName = newText;
		if (this.ready) this.movie.setFileName(newText);
	},
	
	setAction: function(newText) {
		// set action (save or copy)
		this.action = newText;
		if (this.ready) this.movie.setAction(newText);
	},
	
	addEventListener: function(eventName, func) {
		// add user event listener for event
		// event types: load, queueStart, fileStart, fileComplete, queueComplete, progress, error, cancel
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
		if (!this.handlers[eventName]) this.handlers[eventName] = [];
		this.handlers[eventName].push(func);
	},
	
	setHandCursor: function(enabled) {
		// enable hand cursor (true), or default arrow cursor (false)
		this.handCursorEnabled = enabled;
		if (this.ready) this.movie.setHandCursor(enabled);
	},
	
	setCSSEffects: function(enabled) {
		// enable or disable CSS effects on DOM container
		this.cssEffects = !!enabled;
	},
	
	receiveEvent: function(eventName, args) {
		// receive event from flash
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
				
		// special behavior for certain events
		switch (eventName) {
			case 'load':
				// movie claims it is ready, but in IE this isn't always the case...
				// bug fix: Cannot extend EMBED DOM elements in Firefox, must use traditional function
				this.movie = document.getElementById(this.movieId);
				if (!this.movie) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 1 );
					return;
				}
				
				// firefox on pc needs a "kick" in order to set these in certain cases
				if (!this.ready && navigator.userAgent.match(/Firefox/) && navigator.userAgent.match(/Windows/)) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 100 );
					this.ready = true;
					return;
				}
				
				this.ready = true;
				this.movie.clearText();
				this.movie.appendText( this.clipText );
				this.movie.setFileName( this.fileName );
				this.movie.setAction( this.action );
				this.movie.setCharSet( this.charSet );
				this.movie.setBomInc( this.incBom );
				this.movie.setHandCursor( this.handCursorEnabled );
				break;
			
			case 'mouseover':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('hover');
					if (this.recoverActive) this.domElement.addClass('active');
				}
				break;
			
			case 'mouseout':
				if (this.domElement && this.cssEffects) {
					this.recoverActive = false;
					if (this.domElement.hasClass('active')) {
						this.domElement.removeClass('active');
						this.recoverActive = true;
					}
					this.domElement.removeClass('hover');
				}
				break;
			
			case 'mousedown':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('active');
				}
				break;
			
			case 'mouseup':
				if (this.domElement && this.cssEffects) {
					this.domElement.removeClass('active');
					this.recoverActive = false;
				}
				break;
		} // switch eventName
		
		if (this.handlers[eventName]) {
			for (var idx = 0, len = this.handlers[eventName].length; idx < len; idx++) {
				var func = this.handlers[eventName][idx];
			
				if (typeof(func) == 'function') {
					// actual function reference
					func(this, args);
				}
				else if ((typeof(func) == 'object') && (func.length == 2)) {
					// PHP style object + method, i.e. [myObject, 'myMethod']
					func[0][ func[1] ](this, args);
				}
				else if (typeof(func) == 'string') {
					// name of function
					window[func](this, args);
				}
			} // foreach event handler defined
		} // user defined handler for event
	}
	
};
/*
 * File:        TableTools.js
 * Version:     2.0.0
 * Description: Tools and buttons for DataTables
 * Author:      Allan Jardine (www.sprymedia.co.uk)
 * Language:    Javascript
 * License:     LGPL / 3 point BSD
 * Project:     DataTables
 * 
 * Copyright 2009-2010 Allan Jardine, all rights reserved.
 */

/* Global scope for TableTools */
var TableTools;

(function($, window, document) {

/** 
 * TableTools provides flexible buttons and other tools for a DataTables enhanced table
 * @class TableTools
 * @constructor
 * @param {Object} oDT DataTables instance
 * @param {Object} oOpts TableTools options
 * @param {String} oOpts.sSwfPath ZeroClipboard SWF path
 * @param {String} oOpts.sRowSelect Row selection options - 'none', 'single' or 'multi'
 * @param {Function} oOpts.fnPreRowSelect Callback function just prior to row selection
 * @param {Function} oOpts.fnRowSelected Callback function just after row selection
 * @param {Function} oOpts.fnRowDeselected Callback function when row is deselected
 * @param {Array} oOpts.aButtons List of buttons to be used
 */
TableTools = function( oDT, oOpts )
{
	/* Santiy check that we are a new instance */
	if ( !this.CLASS || this.CLASS != "TableTools" )
	{
		alert( "Warning: TableTools must be initialised with the keyword 'new'" );
	}
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public class variables
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/**
	 * @namespace Settings object which contains customisable information for TableTools instance
	 */
	this.s = {
    /**
     * Store 'this' so the instance can be retreieved from the settings object
     *  @property that
     *  @type     object
     *  @default  this
     */
		"that": this,
		
		/** 
		 * DataTables settings objects
     *  @property dt
     *  @type     object
     *  @default  null
		 */
		"dt": null,
		
		/**
		 * @namespace Print specific information
		 */
		"print": {
			/** 
			 * DataTables draw 'start' point before the printing display was shown
       *  @property saveStart
			 *  @type     int
       *  @default  -1
		 	 */
		  "saveStart": -1,
			
			/** 
			 * DataTables draw 'length' point before the printing display was shown
       *  @property saveLength
			 *  @type     int
       *  @default  -1
		 	 */
		  "saveLength": -1,
		
			/** 
			 * Page scrolling point before the printing display was shown so it can be restored
       *  @property saveScroll
			 *  @type     int
       *  @default  -1
		 	 */
		  "saveScroll": -1,
		
			/** 
			 * Wrapped function to end the print display (to maintain scope)
       *  @property funcEnd
		 	 *  @type     Function
       *  @default  function () {}
		 	 */
		  "funcEnd": function () {}
	  },
	
		/**
		 * A unique ID is assigned to each button in each instance
     *  @property buttonCounter
		 *  @type     int
     *  @default  0
		 */
	  "buttonCounter": 0,
		
		/**
		 * @namespace Select rows specific information
		 */
		"select": {
			/**
			 * Select type - can be 'none', 'single' or 'multi'
       *  @property type
			 *  @type     string
       *  @default  ""
			 */
			"type": "",
			
			/**
			 * Array of nodes which are currently selected
       *  @property selected
			 *  @type     array
       *  @default  []
			 */
			"selected": [],
			
			/**
			 * Function to run before the selection can take place. Will cancel the select if the
			 * function returns false
       *  @property preRowSelect
			 *  @type     Function
       *  @default  null
			 */
			"preRowSelect": null,
			
			/**
			 * Function to run when a row is selected
       *  @property postSelected
			 *  @type     Function
       *  @default  null
			 */
			"postSelected": null,
			
			/**
			 * Function to run when a row is deselected
       *  @property postDeselected
			 *  @type     Function
       *  @default  null
			 */
			"postDeselected": null,
			
			/**
			 * Indicate if all rows are selected (needed for server-side processing)
       *  @property all
			 *  @type     boolean
       *  @default  false
			 */
			"all": false
		},
		
		/**
		 * Store of the user input customisation object
     *  @property custom
		 *  @type     object
     *  @default  {}
		 */
		"custom": {},
		
		/**
		 * SWF movie path
     *  @property swfPath
		 *  @type     string
     *  @default  ""
		 */
		"swfPath": "",
		
		/**
		 * Default button set
     *  @property buttonSet
		 *  @type     array
     *  @default  []
		 */
		"buttonSet": [],
		
		/**
		 * When there is more than one TableTools instance for a DataTable, there must be a 
		 * master which controls events (row selection etc)
     *  @property master
		 *  @type     boolean
     *  @default  false
		 */
		"master": false
	};
	
	
	/**
	 * @namespace Common and useful DOM elements for the class instance
	 */
	this.dom = {
		/**
		 * DIV element that is create and all TableTools buttons (and their children) put into
		 *  @property container
		 *  @type     node
		 *  @default  null
		 */
		"container": null,
		
		/**
		 * The table node to which TableTools will be applied
		 *  @property table
		 *  @type     node
		 *  @default  null
		 */
		"table": null,
		
		/**
		 * @namespace Nodes used for the print display
		 */
		"print": {
			/**
			 * Nodes which have been removed from the display by setting them to display none
			 *  @property hidden
			 *  @type     array
		 	 *  @default  []
			 */
		  "hidden": [],
			
			/**
			 * The information display saying tellng the user about the print display
			 *  @property message
			 *  @type     node
		 	 *  @default  null
			 */
		  "message": null
	  },
		
		/**
		 * @namespace Nodes used for a collection display. This contains the currently used collection
		 */
		"collection": {
			/**
			 * The div wrapper containing the buttons in the collection (i.e. the menu)
			 *  @property collection
			 *  @type     node
		 	 *  @default  null
			 */
			"collection": null,
			
			/**
			 * Background display to provide focus and capture events
			 *  @property background
			 *  @type     node
		 	 *  @default  null
			 */
			"background": null
		}
	};
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public class methods
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/**
	 * Retreieve the settings object from an instance
	 *  @method fnSettings
	 *  @returns {object} TableTools settings object
	 */
	this.fnSettings = function () {
		return this.s;
	};
	
	
	/* Constructor logic */
	if ( typeof oOpts == 'undefined' )
	{
		oOpts = {};
	}
	
	this.s.dt = oDT.fnSettings();
	this._fnConstruct( oOpts );
	
	return this;
};



TableTools.prototype = {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/**
	 * Retreieve the settings object from an instance
	 *  @method fnGetSelected
	 *  @returns {array} List of TR nodes which are currently selected
	 */
	"fnGetSelected": function ()
	{
		var masterS = this._fnGetMasterSettings();
		return masterS.select.selected;
	},
	
	/**
	 * Check to see if a current row is selected or not
	 *  @method fnGetSelected
	 *  @param {Node} n TR node to check if it is currently selected or not
	 *  @returns {Boolean} true if select, false otherwise
	 */
	"fnIsSelected": function ( n )
	{
		var selected = this.fnGetSelected();
		for ( var i=0, iLen=selected.length ; i<iLen ; i++ )
		{
			if ( n == selected[i] )
			{
				return true;
			}
		}
		return false;
	},
	
	/**
	 * Select all rows in the table
	 *  @method  fnSelectAll
	 *  @returns void
	 */
	"fnSelectAll": function ()
	{
		var masterS = this._fnGetMasterSettings();
		masterS.that._fnRowSelectAll();
	},
	
	
	/**
	 * Deselect all rows in the table
	 *  @method  fnSelectNone
	 *  @returns void
	 */
	"fnSelectNone": function ()
	{
		var masterS = this._fnGetMasterSettings();
		masterS.that._fnRowDeselectAll();
	},
	
	
	/**
	 * Get the title of the document - useful for file names. The title is retrieved from either
	 * the configuration object's 'title' parameter, or the HTML document title
	 *  @method  fnGetTitle
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns {String} Button title
	 */
	"fnGetTitle": function( oConfig )
	{
		var sTitle = "";
		if ( typeof oConfig.sTitle != 'undefined' && oConfig.sTitle !== "" ) {
			sTitle = oConfig.sTitle;
		} else {
			var anTitle = document.getElementsByTagName('title');
			if ( anTitle.length > 0 )
			{
				sTitle = anTitle[0].innerHTML;
			}
		}
		
		/* Strip characters which the OS will object to - checking for UTF8 support in the scripting
		 * engine
		 */
		if ( "\u00A1".toString().length < 4 ) {
			return sTitle.replace(/[^a-zA-Z0-9_\u00A1-\uFFFF\.,\-_ !\(\)]/g, "-");
		} else {
			return sTitle.replace(/[^a-zA-Z0-9_\.,\-_ !\(\)]/g, "-");
		}
	},
	
	
	/**
	 * Calculate a unity array with the column width by proportion for a set of columns to be
	 * included for a button. This is particularly useful for PDF creation, where we can use the
	 * column widths calculated by the browser to size the columns in the PDF.
	 *  @method  fnCalcColRations
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns {Array} Unity array of column ratios
	 */
	"fnCalcColRatios": function ( oConfig )
	{
		var
			aoCols = this.s.dt.aoColumns,
			aColumnsInc = this._fnColumnTargets( oConfig.mColumns ),
			aColWidths = [],
			iWidth = 0, iTotal = 0, i, iLen;
		
		for ( i=0, iLen=aColumnsInc.length ; i<iLen ; i++ )
		{
			if ( aColumnsInc[i] )
			{
				iWidth = aoCols[i].nTh.offsetWidth;
				iTotal += iWidth;
				aColWidths.push( iWidth );
			}
		}
		
		for ( i=0, iLen=aColWidths.length ; i<iLen ; i++ )
		{
			aColWidths[i] = aColWidths[i] / iTotal;
		}
		
		return aColWidths.join('\t');
	},
	
	
	/**
	 * Get the information contained in a table as a string
	 *  @method  fnGetTableData
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns {String} Table data as a string
	 */
	"fnGetTableData": function ( oConfig )
	{
		/* In future this could be used to get data from a plain HTML source as well as DataTables */
		if ( this.s.dt )
		{
			return this._fnGetDataTablesData( oConfig );
		}
	},
	
	
	/**
	 * Pass text to a flash button instance, which will be used on the button's click handler
	 *  @method  fnSetText
	 *  @param   {Object} clip Flash button object
	 *  @param   {String} text Text to set
	 *  @returns void
	 */
	"fnSetText": function ( clip, text )
	{
		this._fnFlashSetText( clip, text );
	},
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods (they are of course public in JS, but recommended as private)
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
	
	/**
	 * Constructor logic
	 *  @method  _fnConstruct
	 *  @param   {Object} oOpts Same as TableTools constructor
	 *  @returns void
	 *  @private 
	 */
	"_fnConstruct": function ( oOpts )
	{
		this._fnCustomiseSettings( oOpts );
		
		/* Container element */
		this.dom.container = document.createElement('div');
		this.dom.container.style.position = "relative";
		this.dom.container.className = !this.s.dt.bJUI ? "DTTT_container" :
			"DTTT_container ui-buttonset ui-buttonset-multi";
		
		/* Row selection config */
		if ( this.s.select.type != 'none' )
		{
			this._fnRowSelectConfig();
		}
		
		/* Buttons */
		this._fnButtonDefinations( this.s.buttonSet, this.dom.container );
	},
	
	
	/**
	 * Take the user defined settings and the default settings and combine them.
	 *  @method  _fnCustomiseSettings
	 *  @param   {Object} oOpts Same as TableTools constructor
	 *  @returns void
	 *  @private 
	 */
	"_fnCustomiseSettings": function ( oOpts )
	{
		/* Is this the master control instance or not? */
		if ( typeof this.s.dt._TableToolsInit == 'undefined' )
		{
			this.s.master = true;
			this.s.dt._TableToolsInit = true;
		}
		
		/* We can use the table node from comparisons to group controls */
		this.dom.table = this.s.dt.nTable;
		
		/* Clone the defaults and then the user options */
		this.s.custom = $.extend( {}, TableTools.DEFAULTS, oOpts );
		
		/* Flash file location */
		this.s.swfPath = this.s.custom.sSwfPath;
		if ( typeof ZeroClipboard != 'undefined' )
		{
			ZeroClipboard.moviePath = this.s.swfPath;
		}
		
		/* Table row selecting */
		this.s.select.type = this.s.custom.sRowSelect;
		this.s.select.preRowSelect = this.s.custom.fnPreRowSelect;
		this.s.select.postSelected = this.s.custom.fnRowSelected;
		this.s.select.postDeselected = this.s.custom.fnRowDeselected;
		
		/* Button set */
		this.s.buttonSet = this.s.custom.aButtons;
	},
	
	
	/**
	 * Take the user input arrays and expand them to be fully defined, and then add them to a given
	 * DOM element
	 *  @method  _fnButtonDefinations
	 *  @param {array} buttonSet Set of user defined buttons
	 *  @param {node} wrapper Node to add the created buttons to
	 *  @returns void
	 *  @private 
	 */
	"_fnButtonDefinations": function ( buttonSet, wrapper )
	{
		var buttonDef;
		
		for ( var i=0, iLen=buttonSet.length ; i<iLen ; i++ )
		{
			if ( typeof buttonSet[i] == "string" )
			{
				if ( typeof TableTools.BUTTONS[ buttonSet[i] ] == 'undefined' )
				{
					alert( "TableTools: Warning - unknown button type: "+buttonSet[i] );
					continue;
				}
				buttonDef = $.extend( {}, TableTools.BUTTONS[ buttonSet[i] ], true );
			}
			else
			{
				if ( typeof TableTools.BUTTONS[ buttonSet[i].sExtends ] == 'undefined' )
				{
					alert( "TableTools: Warning - unknown button type: "+buttonSet[i].sExtends );
					continue;
				}
				var o = $.extend( {}, TableTools.BUTTONS[ buttonSet[i].sExtends ], true );
				buttonDef = $.extend( o, buttonSet[i], true );
			}
			
			if ( this.s.dt.bJUI )
			{
				/*
				buttonDef.sButtonClass += "";
				buttonDef.sButtonClassHover += " ui-button ui-state-default ui-state-hover";
				*/
			}
			
			wrapper.appendChild( this._fnCreateButton( buttonDef ) );
		}
	},
	
	
	/**
	 * Create and configure a TableTools button
	 *  @method  _fnCreateButton
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns {Node} Button element
	 *  @private 
	 */
	"_fnCreateButton": function ( oConfig )
	{
	  var nButton = this._fnButtonBase( oConfig );
		
    if ( oConfig.sAction == "print" )
    {
      this._fnPrintConfig( nButton, oConfig );
    }
    else if ( oConfig.sAction.match(/flash/) )
    {
      this._fnFlashConfig( nButton, oConfig );
    }
    else if ( oConfig.sAction == "text" )
    {
      this._fnTextConfig( nButton, oConfig );
    }
    else if ( oConfig.sAction == "collection" )
    {
      this._fnTextConfig( nButton, oConfig );
			this._fnCollectionConfig( nButton, oConfig );
    }
		
	  return nButton;
  },
	
	
	/**
	 * Create the DOM needed for the button and apply some base properties. All buttons start here
	 *  @method  _fnButtonBase
	 *  @param   {o} oConfig Button configuration object
	 *  @returns {Node} DIV element for the button
	 *  @private 
	 */
	"_fnButtonBase": function ( o )
	{
		var
		  nButton = document.createElement('button'),
			masterS = this._fnGetMasterSettings();
		
		nButton.className = "DTTT_button "+o.sButtonClass;
		nButton.setAttribute('title',o.sButtonText);
		nButton.setAttribute('id', "ToolTables_"+this.s.dt.sInstance+"_"+masterS.buttonCounter );
		masterS.buttonCounter++;
		
		return nButton;
	},
	
	
	/**
	 * Get the settings object for the master instance. When more than one TableTools instance is
	 * assigned to a DataTable, only one of them can be the 'master' (for the select rows). As such,
	 * we will typically want to interact with that master for global properties.
	 *  @method  _fnGetMasterSettings
	 *  @returns {Object} TableTools settings object
	 *  @private 
	 */
	"_fnGetMasterSettings": function ()
	{
		if ( this.s.master )
		{
			return this.s;
		}
		else
		{
			/* Look for the master which has the same DT as this one */
			var instances = TableTools._aInstances;
			for ( var i=0, iLen=instances.length ; i<iLen ; i++ )
			{
				if ( this.dom.table == instances[i].s.dt.nTable )
				{
					return instances[i].s;
				}
			}
		}
	},
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Button collection functions
	 */
	
	/**
	 * Create a collection button, when activated will present a drop downlist of other buttons
	 *  @param   {Node} nButton Button to use for the collection activation
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns void
	 *  @private
	 */
	"_fnCollectionConfig": function ( nButton, oConfig )
	{
		var nHidden = document.createElement('div');
		nHidden.style.display = "none";
		nHidden.className = !this.s.dt.bJUI ? "DTTT_collection" :
			"DTTT_collection ui-buttonset ui-buttonset-multi";
		oConfig._collection = nHidden;
		
		this._fnButtonDefinations( oConfig.aButtons, nHidden );
	},
	
	
	/**
	 * Show a button collection
	 *  @param   {Node} nButton Button to use for the collection
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns void
	 *  @private
	 */
	"_fnCollectionShow": function ( nButton, oConfig )
	{
		var
			that = this,
			oPos = $(nButton).offset(),
			nHidden = oConfig._collection,
			iDivX = oPos.left,
			iDivY = oPos.top + $(nButton).outerHeight(),
			iWinHeight = $(window).height(), iDocHeight = $(document).height(),
		 	iWinWidth = $(window).width(), iDocWidth = $(document).width();
		
		nHidden.style.position = "absolute";
		nHidden.style.left = iDivX+"px";
		nHidden.style.top = iDivY+"px";
		nHidden.style.display = "block";
		$(nHidden).css('opacity',0);
		
		var nBackground = document.createElement('div');
		nBackground.style.position = "absolute";
		nBackground.style.left = "0px";
		nBackground.style.top = "0px";
		nBackground.style.height = ((iWinHeight>iDocHeight)? iWinHeight : iDocHeight) +"px";
		nBackground.style.width = ((iWinWidth>iDocWidth)? iWinWidth : iDocWidth) +"px";
		nBackground.className = "DTTT_collection_background";
		$(nBackground).css('opacity',0);
		
		document.body.appendChild( nBackground );
		document.body.appendChild( nHidden );
		
		/* Visual corrections to try and keep the collection visible */
		var iDivWidth = $(nHidden).outerWidth();
		var iDivHeight = $(nHidden).outerHeight();
		
		if ( iDivX + iDivWidth > iDocWidth )
		{
			nHidden.style.left = (iDocWidth-iDivWidth)+"px";
		}
		
		if ( iDivY + iDivHeight > iDocHeight )
		{
			nHidden.style.top = (iDivY-iDivHeight-$(nButton).outerHeight())+"px";
		}
	
		this.dom.collection.collection = nHidden;
		this.dom.collection.background = nBackground;
		
		/* This results in a very small delay for the end user but it allows the animation to be
		 * much smoother. If you don't want the animation, then the setTimeout can be removed
		 */
		setTimeout( function () {
			$(nHidden).animate({"opacity": 1}, 500);
			$(nBackground).animate({"opacity": 0.25}, 500);
		}, 10 );
		
		/* Event handler to remove the collection display */
		$(nBackground).click( function () {
			that._fnCollectionHide.call( that, null, null );
		} );
	},
	
	
	/**
	 * Hide a button collection
	 *  @param   {Node} nButton Button to use for the collection
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns void
	 *  @private
	 */
	"_fnCollectionHide": function ( nButton, oConfig )
	{
		if ( oConfig !== null && oConfig.sExtends == 'collection' )
		{
			return;
		}
		
		if ( this.dom.collection.collection !== null )
		{
			$(this.dom.collection.collection).animate({"opacity": 0}, 500, function (e) {
				this.style.display = "none";
			} );
			
			$(this.dom.collection.background).animate({"opacity": 0}, 500, function (e) {
				this.parentNode.removeChild( this );
			} );
			
			this.dom.collection.collection = null;
			this.dom.collection.background = null;
		}
	},
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Row selection functions
	 */
	
	/**
	 * Add event handlers to a table to allow for row selection
	 *  @method  _fnRowSelectConfig
	 *  @returns void
	 *  @private 
	 */
	"_fnRowSelectConfig": function ()
	{
		if ( this.s.master )
		{
			var
				that = this, 
				i, iLen, 
				aoOpenRows = this.s.dt.aoOpenRows;
			
			$(that.s.dt.nTable).addClass( 'DTTT_selectable' );
			
			$('tr', that.s.dt.nTBody).live( 'click', function(e) {
				/* Sub-table must be ignored (odd that the selector won't do this with >) */
				if ( this.parentNode != that.s.dt.nTBody )
				{
					return;
				}
				
				/* Not interested in selecting 'opened' rows */
				for ( i=0, iLen=aoOpenRows.length ; i<iLen ; i++ )
				{
					if ( this == aoOpenRows[i].nTr )
					{
						return;
					}
				}
				
				/* User defined selection function */
				if ( that.s.select.preRowSelect !== null && !that.s.select.preRowSelect.call(that, e) )
				{
					return;
				}
				
				/* And go */
				if ( that.s.select.type == "single" )
				{
					that._fnRowSelectSingle.call( that, this );
				}
				else
				{
					that._fnRowSelectMulti.call( that, this );
				}
			} );
			
			/* Add a draw callback handler for when 'select' all is active and we are using server-side
			 * processing, so TableTools will automatically select the new rows for us
			 */
			that.s.dt.aoDrawCallback.push( {
				"fn": function () {
					if ( that.s.select.all && that.s.dt.oFeatures.bServerSide )
					{
						that.fnSelectAll();
					}
				},
				"sName": "TableTools_select"
			} );
		}
	},
	
	
	/**
	 * Select or deselect a row based on its current state when only one row is allowed to be
	 * selected at a time (i.e. if there is a row already selected, deselect it). If the selected
	 * row is the one being passed in, just deselect and take no further action.
	 *  @method  _fnRowSelectSingle
	 *  @param   {Node} nNode TR element which is being 'activated' in some way
	 *  @returns void
	 *  @private 
	 */
	"_fnRowSelectSingle": function ( nNode )
	{
		if ( this.s.master )
		{
			/* Do nothing on the DataTables 'empty' result set row */
			if ( $('td', nNode).hasClass(this.s.dt.oClasses.sRowEmpty) )
			{
				return;
			}
			
			if ( $(nNode).hasClass('DTTT_selected') )
			{
				this._fnRowDeselect( nNode );
			}
			else
			{
				if ( this.s.select.selected.length !== 0 )
				{
					this._fnRowDeselectAll();
				}
				
				this.s.select.selected.push( nNode );
				$(nNode).addClass( 'DTTT_selected' );
				
				if ( this.s.select.postSelected !== null )
				{
					this.s.select.postSelected.call( this, nNode );
				}
			}
			
			TableTools._fnEventDispatch( this, 'select', nNode );
		}
	},
	
	
	/**
	 * Select or deselect a row based on its current state when multiple rows are allowed to be
	 * selected.
	 *  @method  _fnRowSelectMulti
	 *  @param   {Node} nNode TR element which is being 'activated' in some way
	 *  @returns void
	 *  @private 
	 */
	"_fnRowSelectMulti": function ( nNode )
	{
		if ( this.s.master )
		{
			/* Do nothing on the DataTables 'empty' result set row */
			if ( $('td', nNode).hasClass(this.s.dt.oClasses.sRowEmpty) )
			{
				return;
			}
			
			if ( $(nNode).hasClass('DTTT_selected') )
			{
				this._fnRowDeselect( nNode );
			}
			else
			{
				this.s.select.selected.push( nNode );
				$(nNode).addClass( 'DTTT_selected' );
				
				if ( this.s.select.postSelected !== null )
				{
					this.s.select.postSelected.call( this, nNode );
				}
			}
			
			TableTools._fnEventDispatch( this, 'select', nNode );
		}
	},
	
	
	/**
	 * Select all TR elements in the table. Note that this function will still operate in 'single'
	 * select mode, which might not be what you desire (in which case, don't call this function!)
	 *  @method  _fnRowSelectAll
	 *  @returns void
	 *  @private 
	 */
	"_fnRowSelectAll": function ( )
	{
		if ( this.s.master )
		{
			var n;
			for ( var i=0, iLen=this.s.dt.aiDisplayMaster.length ; i<iLen ; i++ )
			{
				n = this.s.dt.aoData[ this.s.dt.aiDisplayMaster[i] ].nTr;
				
				if ( !$(n).hasClass('DTTT_selected') )
				{
					this.s.select.selected.push( n );
					$(n).addClass( 'DTTT_selected' );
				}
			}
			
			this.s.select.all = true;
			TableTools._fnEventDispatch( this, 'select', null );
		}
	},
	
	
	/**
	 * Deselect all TR elements in the table. If nothing is currently selected, then no action is
	 * taken.
	 *  @method  _fnRowDeselectAll
	 *  @returns void
	 *  @private 
	 */
	"_fnRowDeselectAll": function ( )
	{
		if ( this.s.master )
		{
			for ( var i=this.s.select.selected.length-1 ; i>=0 ; i-- )
			{
				this._fnRowDeselect( i );
			}
			
			this.s.select.all = false;
			TableTools._fnEventDispatch( this, 'select', null );
		}
	},
	
	
	/**
	 * Deselect a single row, based on its index in the selected array, or a TR node (when the
	 * index is then computed)
	 *  @method  _fnRowDeselect
	 *  @param   {int|Node} i Node or index of node in selected array, which is to be deselected
	 *  @returns void
	 *  @private 
	 */
	"_fnRowDeselect": function ( i )
	{
		if ( typeof i.nodeName != 'undefined' )
		{
			i = $.inArray( i, this.s.select.selected );
		}
		
		var nNode = this.s.select.selected[i];
		$(nNode).removeClass('DTTT_selected');
		this.s.select.selected.splice( i, 1 );
		
		if ( this.s.select.postDeselected !== null )
		{
			this.s.select.postDeselected.call( this, nNode );
		}
		
		this.s.select.all = false;
	},
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Text button functions
	 */
	
	/**
	 * Configure a text based button for interaction events
	 *  @method  _fnTextConfig
	 *  @param   {Node} nButton Button element which is being considered
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns void
	 *  @private 
	 */
	"_fnTextConfig": function ( nButton, oConfig )
	{
		var that = this;
		
		if ( oConfig.fnInit !== null )
		{
			oConfig.fnInit.call( this, nButton, oConfig );
		}
		
		if ( oConfig.sToolTip != "" )
		{
			nButton.title = oConfig.sToolTip;
		}
		
	  $(nButton).hover( function () {
			$(nButton).removeClass( oConfig.sButtonClass ).
				addClass(oConfig.sButtonClassHover );
			if ( oConfig.fnMouseover !== null )
			{
				oConfig.fnMouseover.call( this, nButton, oConfig, null );
			}
		}, function () {
			$(nButton).removeClass( oConfig.sButtonClassHover ).
				addClass( oConfig.sButtonClass );
			if ( oConfig.fnMouseout !== null )
			{
				oConfig.fnMouseout.call( this, nButton, oConfig, null );
			}
		} );
		
		if ( oConfig.fnSelect !== null )
		{
			TableTools._fnEventListen( this, 'select', function (n) {
				oConfig.fnSelect.call( that, nButton, oConfig, n );
			} );
		}
		
		$(nButton).click( function (e) {
			e.preventDefault();
			
			if ( oConfig.fnClick !== null )
			{
				oConfig.fnClick.call( that, nButton, oConfig, null );
			}
			
			/* Provide a complete function to match the behaviour of the flash elements */
			if ( oConfig.fnComplete !== null )
			{
				oConfig.fnComplete.call( that, nButton, oConfig, null, null );
			}
			
			that._fnCollectionHide( nButton, oConfig );
		} );
	},
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Flash button functions
	 */
	
	/**
	 * Configure a flash based button for interaction events
	 *  @method  _fnFlashConfig
	 *  @param   {Node} nButton Button element which is being considered
	 *  @param   {o} oConfig Button configuration object
	 *  @returns void
	 *  @private 
	 */
	"_fnFlashConfig": function ( nButton, oConfig )
	{
	  var that = this;
		var flash = new ZeroClipboard.Client();
		
		if ( oConfig.fnInit !== null )
		{
			oConfig.fnInit.call( this, nButton, oConfig );
		}
		
		flash.setHandCursor( true );
		
		formatFileName = function(titleHtml){
			var ext = titleHtml.substr(1);
			var dNow = new Date();
			var sNow = "_"+dNow.getFullYear()+"-"+zeroPad(dNow.getMonth()+1,2)+"-"+zeroPad(dNow.getDate(),2)+"_"+zeroPad(dNow.getHours(),2)+"-"+zeroPad(dNow.getMinutes(),2)+"-"+zeroPad(dNow.getSeconds(),2);
			titleHtml = that.fnGetTitle(oConfig) + sNow + ext;
			return titleHtml.replace(/\s+/g," ")
		}
		
		if ( oConfig.sAction == "flash_save" )
		{
			flash.setAction( 'save' );
			flash.setCharSet( (oConfig.sCharSet=="utf16le") ? 'UTF16LE' : 'UTF8' );
			flash.setBomInc( oConfig.bBomInc );
			flash.setFileName(formatFileName(oConfig.sFileName));
		}
		else if ( oConfig.sAction == "flash_pdf" )
		{
			flash.setAction( 'pdf' );
			flash.setFileName(formatFileName(oConfig.sFileName));
		}
		else
		{
			flash.setAction( 'copy' );
		}
		
		flash.addEventListener('mouseOver', function(client) {
			$(nButton).removeClass( oConfig.sButtonClass ).
				addClass(oConfig.sButtonClassHover );
			
			if ( oConfig.fnMouseover !== null )
			{
				oConfig.fnMouseover.call( that, nButton, oConfig, flash );
			}
		} );
		
		flash.addEventListener('mouseOut', function(client) {
			$(nButton).removeClass( oConfig.sButtonClassHover ).
				addClass(oConfig.sButtonClass );
			
			if ( oConfig.fnMouseout !== null )
			{
				oConfig.fnMouseout.call( that, nButton, oConfig, flash );
			}
		} );
		
		flash.addEventListener('mouseDown', function(client) {
			if ( oConfig.fnClick !== null )
			{
				oConfig.fnClick.call( that, nButton, oConfig, flash );
			}
		} );
		
		flash.addEventListener('complete', function (client, text) {
			if ( oConfig.fnComplete !== null )
			{
				oConfig.fnComplete.call( that, nButton, oConfig, flash, text );
			}
			that._fnCollectionHide( nButton, oConfig );
		} );
		
		this._fnFlashGlue( flash, nButton, oConfig.sToolTip );
	},
	
	
	/**
	 * Wait until the id is in the DOM before we "glue" the swf. Note that this function will call
	 * itself (using setTimeout) until it completes successfully
	 *  @method  _fnFlashGlue
	 *  @param   {Object} clip Zero clipboard object
	 *  @param   {Node} node node to glue swf to
	 *  @param   {String} text title of the flash movie
	 *  @returns void
	 *  @private 
	 */
	"_fnFlashGlue": function ( flash, node, text )
	{
	  var that = this;
	  var id = node.getAttribute('id');
	  
		if ( document.getElementById(id) )
		{
			flash.glue( node, text );
		}
		else
		{
			setTimeout( function () {
				that._fnFlashGlue( flash, node, text );
			}, 100 );
		}
	},
	
	
	/**
	 * Set the text for the flash clip to deal with
	 * 
	 * This function is required for large information sets. There is a limit on the 
	 * amount of data that can be transfered between Javascript and Flash in a single call, so
	 * we use this method to build up the text in Flash by sending over chunks. It is estimated
	 * that the data limit is around 64k, although it is undocuments, and appears to be different
	 * between different flash versions. We chunk at 8KiB.
	 *  @method  _fnFlashSetText
	 *  @param   {Object} clip the ZeroClipboard object
	 *  @param   {String} sData the data to be set
	 *  @returns void
	 *  @private 
	 */
	"_fnFlashSetText": function ( clip, sData )
	{
		var asData = this._fnChunkData( sData, 8192 );
		
		clip.clearText();
		for ( var i=0, iLen=asData.length ; i<iLen ; i++ )
		{
			clip.appendText( asData[i] );
		}
	},
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Data retrieval functions
	 */
	
	/**
	 * Convert the mixed columns variable into a boolean array the same size as the columns, which
	 * indicates which columns we want to include
	 *  @method  _fnColumnTargets
	 *  @param   {String|Array} mColumns The columns to be included in data retreieval. If a string
	 *             then it can take the value of "visible" or "hidden" (to include all visible or
	 *             hidden columns respectively). Or an array of column indexes
	 *  @returns {Array} A boolean array the length of the columns of the table, which each value
	 *             indicating if the column is to be included or not
	 *  @private 
	 */
	"_fnColumnTargets": function ( mColumns )
	{
		var aColumns = [];
		var dt = this.s.dt;
		
		if ( typeof mColumns == "object" )
		{
			for ( i=0, iLen=dt.aoColumns.length ; i<iLen ; i++ )
			{
				aColumns.push( false );
			}
			
			for ( i=0, iLen=mColumns.length ; i<iLen ; i++ )
			{
				aColumns[ mColumns[i] ] = true;
			}
		}
		else if ( mColumns == "visible" )
		{
			for ( i=0, iLen=dt.aoColumns.length ; i<iLen ; i++ )
			{
				aColumns.push( dt.aoColumns[i].bVisible ? true : false );
			}
		}
		else if ( mColumns == "hidden" )
		{
			for ( i=0, iLen=dt.aoColumns.length ; i<iLen ; i++ )
			{
				aColumns.push( dt.aoColumns[i].bVisible ? false : true );
			}
		}
		else /* all */
		{
			for ( i=0, iLen=dt.aoColumns.length ; i<iLen ; i++ )
			{
				aColumns.push( true );
			}
		}
		
		return aColumns;
	},
	
	
	/**
	 * New line character(s) depend on the platforms
	 *  @method  method
	 *  @param   {Object} oConfig Button configuration object - only interested in oConfig.sNewLine
	 *  @returns {String} Newline character
	 */
	"_fnNewline": function ( oConfig )
	{
		if ( oConfig.sNewLine == "auto" )
		{
			return navigator.userAgent.match(/Windows/) ? "\r\n" : "\n";
		}
		else
		{
			return oConfig.sNewLine;
		}
	},
	
	
	/**
	 * Get data from DataTables' internals and format it for output
	 *  @method  _fnGetDataTablesData
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns {String} Concatinated string of data
	 *  @private 
	 */
	"_fnGetDataTablesData": function ( oConfig )
	{
		var i, iLen, j, jLen;
		var sData = '', sLoopData = '';
		var dt = this.s.dt;
		var regex = new RegExp(oConfig.sFieldBoundary, "g"); /* Do it here for speed */
		var aColumnsInc = this._fnColumnTargets( oConfig.mColumns );
		var sNewline = this._fnNewline( oConfig );
		/*
		 * Header
		 */
		if ( oConfig.bHeader )
		{
			for ( i=0, iLen=dt.aoColumns.length ; i<iLen ; i++ )
			{
				if ( aColumnsInc[i] )
				{
					var sTitle = dt.aoColumns[i].sTitle;
					log(sTitle);
					sLoopData = sTitle.replace(/\n/g,"").replace( /<.*?>/g, " " );
					sLoopData = this._fnHtmlDecode( sLoopData );
					
					sData += this._fnBoundData( sLoopData, oConfig.sFieldBoundary, regex ) +
					 	oConfig.sFieldSeperator;
				}
			}
			sData = sData.slice( 0, oConfig.sFieldSeperator.length*-1 );
			sData += sNewline;
		}
		/*
		 * Body
		 */
		for ( j=0, jLen=dt.aiDisplay.length ; j<jLen ; j++ )
		{
			/* Columns */
			for ( i=0, iLen=dt.aoColumns.length ; i<iLen ; i++ )
			{
				if ( aColumnsInc[i] )
				{
					/* Convert to strings (with small optimisation) */
					var mTypeData = dt.aoData[ dt.aiDisplay[j] ]._aData[ i ];
					if ( typeof mTypeData == "string" )
					{
						/* Strip newlines, replace img tags with alt attr. and finally strip html... */
						sLoopData = mTypeData.replace(/\n/g," ");
						sLoopData =
						 	sLoopData.replace(/<img.*?\s+alt\s*=\s*(?:"([^"]+)"|'([^']+)'|([^\s>]+)).*?>/gi,
						 		'$1$2$3');
						sLoopData = sLoopData.replace( /<.*?>/g, "" );
					}
					else
					{
						sLoopData = mTypeData+"";
					}
					
					/* Trim and clean the data */
					sLoopData = sLoopData.replace(/^\s+/, '').replace(/\s+$/, '');
					sLoopData = this._fnHtmlDecode( sLoopData );
					
					/* Bound it and add it to the total data */
					sData += this._fnBoundData( sLoopData, oConfig.sFieldBoundary, regex ) +
					 	oConfig.sFieldSeperator;
				}
			}
			sData = sData.replace(/(\t|\s){2,}/g," ").slice( 0, oConfig.sFieldSeperator.length*-1 );
			sData += sNewline;
		}
		
		/* Remove the last new line */
		sData.slice( 0, -1 );
		
		/*
		 * Footer
		 */
		if ( oConfig.bFooter )
		{
			for ( i=0, iLen=dt.aoColumns.length ; i<iLen ; i++ )
			{
				if ( aColumnsInc[i] && dt.aoColumns[i].nTf !== null )
				{
					sLoopData = dt.aoColumns[i].nTf.innerHTML.replace(/\n/g," ").replace( /<.*?>/g, "" );
					sLoopData = this._fnHtmlDecode( sLoopData );
					
					sData += this._fnBoundData( sLoopData, oConfig.sFieldBoundary, regex ) +
					 	oConfig.sFieldSeperator;
				}
			}
			sData = sData.slice( 0, oConfig.sFieldSeperator.length*-1 );
		}
		
		/* No pointers here - this is a string copy :-) */
		_sLastData = sData;
		return sData;
	},
	
	
	/**
	 * Wrap data up with a boundary string
	 *  @method  _fnBoundData
	 *  @param   {String} sData data to bound
	 *  @param   {String} sBoundary bounding char(s)
	 *  @param   {RegExp} regex search for the bounding chars - constructed outside for efficincy
	 *             in the loop
	 *  @returns {String} bound data
	 *  @private 
	 */
	"_fnBoundData": function ( sData, sBoundary, regex )
	{
		if ( sBoundary === "" )
		{
			return sData;
		}
		else
		{
			return sBoundary + sData.replace(regex, "\\"+sBoundary) + sBoundary;
		}
	},
	
	
	/**
	 * Break a string up into an array of smaller strings
	 *  @method  _fnChunkData
	 *  @param   {String} sData data to be broken up
	 *  @param   {Int} iSize chunk size
	 *  @returns {Array} String array of broken up text
	 *  @private 
	 */
	"_fnChunkData": function ( sData, iSize )
	{
		var asReturn = [];
		var iStrlen = sData.length;
		
		for ( var i=0 ; i<iStrlen ; i+=iSize )
		{
			if ( i+iSize < iStrlen )
			{
				asReturn.push( sData.substring( i, i+iSize ) );
			}
			else
			{
				asReturn.push( sData.substring( i, iStrlen ) );
			}
		}
		
		return asReturn;
	},
	
	"_fnGetAsHTML": function(oConfig){
		var html = "<html><thead>";
		
		//stilos;
		html +="<style type='text/css'>";
		html +="table{border: 1px solid #CCC; border-collapse: collapse; text-align:center} ";
		html +=".inline{display:inline} ";
		html +=".oculto{display:none} ";
		html +="tr{border:1px solid #EEE;} ";
		html +="thead{background-color:#CCC;} ";
		html +=".subtitle-header{font-size:8pt;} ";
		html +=".strong{background-color:#AAA; font-weight:bold}";
		html +="</style>";
		
		// tabla
		html +="</thead><tbody>";
		html += this.dom.table.outerHTML;
		
		//cierre
		html +="</tbody></html>";
		return html;
	},
	/**
	 * Decode HTML entities
	 *  @method  _fnHtmlDecode
	 *  @param   {String} sData encoded string
	 *  @returns {String} decoded string
	 *  @private 
	 */
	"_fnHtmlDecode": function ( sData )
	{
		if ( sData.indexOf('&') == -1 )
		{
			return sData;
		}
		
		var 
			aData = this._fnChunkData( sData, 2048 ),
			n = document.createElement('div'),
			i, iLen, iIndex,
			sReturn = "", sInner;
		
		/* nodeValue has a limit in browsers - so we chunk the data into smaller segments to build
		 * up the string. Note that the 'trick' here is to remember than we might have split over
		 * an HTML entity, so we backtrack a little to make sure this doesn't happen
		 */
		for ( i=0, iLen=aData.length ; i<iLen ; i++ )
		{
			/* Magic number 8 is because no entity is longer then strlen 8 in ISO 8859-1 */
			iIndex = aData[i].lastIndexOf( '&' );
			if ( iIndex != -1 && aData[i].length >= 8 && iIndex > aData[i].length - 8 )
			{
				sInner = aData[i].substr( iIndex );
				aData[i] = aData[i].substr( 0, iIndex );
			}
			
			n.innerHTML = aData[i];
			sReturn += n.childNodes[0].nodeValue;
		}
		
		return sReturn;
	},
	
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Printing functions
	 */
	
	/**
	 * Configure a button for printing
	 *  @method  _fnPrintConfig
	 *  @param   {Node} nButton Button element which is being considered
	 *  @param   {Object} oConfig Button configuration object
	 *  @returns void
	 *  @private 
	 */
	"_fnPrintConfig": function ( nButton, oConfig )
	{
	  var that = this;
		
		if ( oConfig.fnInit !== null )
		{
			oConfig.fnInit.call( this, nButton, oConfig );
		}

	  $(nButton).hover( function () {
			$(nButton).removeClass( oConfig.sButtonClass ).
				addClass(oConfig.sButtonClassHover );
		}, function () {
			$(nButton).removeClass( oConfig.sButtonClassHover ).
				addClass(oConfig.sButtonClass );
		} );
		
		if ( oConfig.fnSelect !== null )
		{
			TableTools._fnEventListen( this, 'select', function (n) {
				oConfig.fnSelect.call( that, nButton, oConfig, n );
			} );
		}
		
		$(nButton).click( function (e) {
			e.preventDefault();
			
			that._fnPrintStart.call( that, e, oConfig);
			
			if ( oConfig.fnClick !== null )
			{
				oConfig.fnClick.call( that, nButton, oConfig, null );
			}
			
			/* Provide a complete function to match the behaviour of the flash elements */
			if ( oConfig.fnComplete !== null )
			{
				oConfig.fnComplete.call( that, nButton, oConfig, null, null );
			}
			
			that._fnCollectionHide( nButton, oConfig );
		} );
  },
  
  /**
   * Show print display
   *  @method  _fnPrintStart
   *  @param   {Event} e Event object
	 *  @param   {Object} oConfig Button configuration object
   *  @returns void
	 *  @private 
   */
  "_fnPrintStart": function ( e, oConfig )
	{
	  var that = this;
	  var oSetDT = this.s.dt;
	  
    /* Parse through the DOM hiding everything that isn't needed for the table */
    this._fnPrintHideNodes( oSetDT.nTable );
		
    /* Show the whole table */
    this.s.print.saveStart = oSetDT._iDisplayStart;
    this.s.print.saveLength = oSetDT._iDisplayLength;

		if ( oConfig.bShowAll )
		{
    	oSetDT._iDisplayStart = 0;
    	oSetDT._iDisplayLength = -1;
    	oSetDT.oApi._fnCalculateEnd( oSetDT );
    	oSetDT.oApi._fnDraw( oSetDT );
		}
		
		/* Adjust the display for scrolling which might be done by DataTables */
		if ( oSetDT.oScroll.sX !== "" || oSetDT.oScroll.sY !== "" )
		{
			this._fnPrintScrollStart( oSetDT );
		}
		
		/* Remove the other DataTables feature nodes - but leave the table! and info div */
		var anFeature = oSetDT.aanFeatures;
		for ( var cFeature in anFeature )
		{
			if ( cFeature != 'i' && cFeature != 't' && cFeature.length == 1 )
			{
			  for ( var i=0, iLen=anFeature[cFeature].length ; i<iLen ; i++ )
			  {
				  this.dom.print.hidden.push( {
				  	"node": anFeature[cFeature][i],
				  	"display": "block"
				  } );
				  anFeature[cFeature][i].style.display = "none";
			  }
			}
		}
		
		/* Print class can be used for styling */
		$(document.body).addClass( 'DTTT_Print' );
    
    /* Add a node telling the user what is going on */
    if ( oConfig.sInfo !== "" )
    {
      var nInfo = document.createElement( "div" );
      nInfo.className = "DTTT_print_info";
      nInfo.innerHTML = oConfig.sInfo;
      document.body.appendChild( nInfo );
      
      setTimeout( function() {
      	$(nInfo).fadeOut( "normal", function() {
      		document.body.removeChild( nInfo );
      	} );
      }, 2000 );
    }
    
    /* Add a message at the top of the page */
    if ( oConfig.sMessage !== "" )
    {
    	this.dom.print.message = document.createElement( "div" );
    	this.dom.print.message.className = "DTTT_PrintMessage";
    	this.dom.print.message.innerHTML = oConfig.sMessage;
    	document.body.insertBefore( this.dom.print.message, document.body.childNodes[0] );
    }
    
    /* Cache the scrolling and the jump to the top of the t=page */
    this.s.print.saveScroll = $(window).scrollTop();
    window.scrollTo( 0, 0 );
    
    this.s.print.funcEnd = function(e) {
     that._fnPrintEnd.call( that, e ); 
    };
    $(document).bind( "keydown", null, this.s.print.funcEnd );
  },
  
	
	/**
	 * Printing is finished, resume normal display
	 *  @method  _fnPrintEnd
	 *  @param   {Event} e Event object
	 *  @returns void
	 *  @private 
	 */
  "_fnPrintEnd": function ( e )
	{
		/* Only interested in the escape key */
		if ( e.keyCode == 27 )
		{
			e.preventDefault();
			
		  var that = this;
	    var oSetDT = this.s.dt;
	    var oSetPrint = this.s.print;
	    var oDomPrint = this.dom.print;
	    
			/* Show all hidden nodes */
			this._fnPrintShowNodes();
			
			/* Restore DataTables' scrolling */
			if ( oSetDT.oScroll.sX !== "" || oSetDT.oScroll.sY !== "" )
			{
				this._fnPrintScrollEnd();
			}
			
			/* Restore the scroll */
			window.scrollTo( 0, oSetPrint.saveScroll );
			
			/* Drop the print message */
			if ( oDomPrint.message !== null )
			{
				document.body.removeChild( oDomPrint.message );
				oDomPrint.message = null;
			}
			
			/* Styling class */
			$(document.body).removeClass( 'DTTT_Print' );
			
			/* Restore the table length */
			oSetDT._iDisplayStart = oSetPrint.saveStart;
			oSetDT._iDisplayLength = oSetPrint.saveLength;
			oSetDT.oApi._fnCalculateEnd( oSetDT );
			oSetDT.oApi._fnDraw( oSetDT );
			
			$(document).unbind( "keydown", this.s.print.funcEnd );
			this.s.print.funcEnd = null;
		}
	},
	
	
	/**
	 * Take account of scrolling in DataTables by showing the full table
	 *  @returns void
	 *  @private 
	 */
	"_fnPrintScrollStart": function ()
	{
		var 
			oSetDT = this.s.dt,
			nScrollHeadInner = oSetDT.nScrollHead.getElementsByTagName('div')[0],
			nScrollHeadTable = nScrollHeadInner.getElementsByTagName('table')[0],
			nScrollBody = oSetDT.nTable.parentNode;

		/* Copy the header in the thead in the body table, this way we show one single table when
		 * in print view. Note that this section of code is more or less verbatim from DT 1.7.0
		 */
		var nTheadSize = oSetDT.nTable.getElementsByTagName('thead');
		if ( nTheadSize.length > 0 )
		{
			oSetDT.nTable.removeChild( nTheadSize[0] );
		}
		
		if ( oSetDT.nTFoot !== null )
		{
			var nTfootSize = oSetDT.nTable.getElementsByTagName('tfoot');
			if ( nTfootSize.length > 0 )
			{
				oSetDT.nTable.removeChild( nTfootSize[0] );
			}
		}
		
		nTheadSize = oSetDT.nTHead.cloneNode(true);
		oSetDT.nTable.insertBefore( nTheadSize, oSetDT.nTable.childNodes[0] );
		
		if ( oSetDT.nTFoot !== null )
		{
			nTfootSize = oSetDT.nTFoot.cloneNode(true);
			oSetDT.nTable.insertBefore( nTfootSize, oSetDT.nTable.childNodes[1] );
		}
		
		/* Now adjust the table's viewport so we can actually see it */
		if ( oSetDT.oScroll.sX !== "" )
		{
			oSetDT.nTable.style.width = $(oSetDT.nTable).outerWidth()+"px";
			nScrollBody.style.width = $(oSetDT.nTable).outerWidth()+"px";
			nScrollBody.style.overflow = "visible";
		}
		
		if ( oSetDT.oScroll.sY !== "" )
		{
			nScrollBody.style.height = $(oSetDT.nTable).outerHeight()+"px";
			nScrollBody.style.overflow = "visible";
    }
	},
	
	
	/**
	 * Take account of scrolling in DataTables by showing the full table. Note that the redraw of
	 * the DataTable that we do will actually deal with the majority of the hardword here
	 *  @returns void
	 *  @private 
	 */
	"_fnPrintScrollEnd": function ()
	{
		var 
			oSetDT = this.s.dt,
			nScrollBody = oSetDT.nTable.parentNode;
		
		if ( oSetDT.oScroll.sX !== "" )
		{
			nScrollBody.style.width = oSetDT.oApi._fnStringToCss( oSetDT.oScroll.sX );
			nScrollBody.style.overflow = "auto";
		}
		
		if ( oSetDT.oScroll.sY !== "" )
		{
			nScrollBody.style.height = oSetDT.oApi._fnStringToCss( oSetDT.oScroll.sY );
			nScrollBody.style.overflow = "auto";
		}
	},
	
	
	/**
	 * Resume the display of all TableTools hidden nodes
	 *  @method  _fnPrintShowNodes
	 *  @returns void
	 *  @private 
	 */
  "_fnPrintShowNodes": function ( )
	{
	  var anHidden = this.dom.print.hidden;
	  
		for ( var i=0, iLen=anHidden.length ; i<iLen ; i++ )
		{
			anHidden[i].node.style.display = anHidden[i].display;
		}
		anHidden.splice( 0, anHidden.length );
	},
	
	
	/**
	 * Hide nodes which are not needed in order to display the table. Note that this function is
	 * recursive
	 *  @method  _fnPrintHideNodes
	 *  @param   {Node} nNode Element which should be showing in a 'print' display
	 *  @returns void
	 *  @private 
	 */
  "_fnPrintHideNodes": function ( nNode )
	{
	  var anHidden = this.dom.print.hidden;
	  
		var nParent = nNode.parentNode;
		var nChildren = nParent.childNodes;
		for ( var i=0, iLen=nChildren.length ; i<iLen ; i++ )
		{
			if ( nChildren[i] != nNode && nChildren[i].nodeType == 1 )
			{
				/* If our node is shown (don't want to show nodes which were previously hidden) */
				var sDisplay = $(nChildren[i]).css("display");
			 	if ( sDisplay != "none" )
				{
					/* Cache the node and it's previous state so we can restore it */
					anHidden.push( {
						"node": nChildren[i],
						"display": sDisplay
					} );
					nChildren[i].style.display = "none";
				}
			}
		}
		
		if ( nParent.nodeName != "BODY" )
		{
			this._fnPrintHideNodes( nParent );
		}
	}
};



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Static variables
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Store of all instances that have been created of TableTools, so one can look up other (when
 * there is need of a master)
 *  @property _aInstances
 *  @type     Array
 *  @default  []
 *  @private
 */
TableTools._aInstances = [];


/**
 * Store of all listeners and their callback functions
 *  @property _aListeners
 *  @type     Array
 *  @default  []
 */
TableTools._aListeners = [];



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Static methods
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Get an array of all the master instances
 *  @method  fnGetMasters
 *  @returns {Array} List of master TableTools instances
 *  @static
 */
TableTools.fnGetMasters = function ()
{
	var a = [];
	for ( var i=0, iLen=TableTools._aInstances.length ; i<iLen ; i++ )
	{
		if ( TableTools._aInstances[i].s.master )
		{
			a.push( TableTools._aInstances[i].s );
		}
	}
	return a;
};

/**
 * Get the master instance for a table node (or id if a string is given)
 *  @method  fnGetInstance
 *  @returns {Object} ID of table OR table node, for which we want the TableTools instance
 *  @static
 */
TableTools.fnGetInstance = function ( node )
{
	if ( typeof node != 'object' )
	{
		node = document.getElementById(node);
	}
	
	for ( var i=0, iLen=TableTools._aInstances.length ; i<iLen ; i++ )
	{
		if ( TableTools._aInstances[i].s.master && TableTools._aInstances[i].dom.table == node )
		{
			return TableTools._aInstances[i];
		}
	}
	return null;
};


/**
 * Add a listener for a specific event
 *  @method  _fnEventListen
 *  @param   {Object} that Scope of the listening function (i.e. 'this' in the caller)
 *  @param   {String} type Event type
 *  @param   {Function} fn Function
 *  @returns void
 *  @private
 *  @static
 */
TableTools._fnEventListen = function ( that, type, fn )
{
	TableTools._aListeners.push( {
		"that": that,
		"type": type,
		"fn": fn
	} );
};
	

/**
 * An event has occured - look up every listener and fire it off. We check that the event we are
 * going to fire is attached to the same table (using the table node as reference) before firing
 *  @method  _fnEventDispatch
 *  @param   {Object} that Scope of the listening function (i.e. 'this' in the caller)
 *  @param   {String} type Event type
 *  @param   {Node} node Element that the event occured on (may be null)
 *  @returns void
 *  @private
 *  @static
 */
TableTools._fnEventDispatch = function ( that, type, node )
{
	var listeners = TableTools._aListeners;
	for ( var i=0, iLen=listeners.length ; i<iLen ; i++ )
	{
		if ( that.dom.table == listeners[i].that.dom.table && listeners[i].type == type )
		{
			listeners[i].fn( node );
		}
	}
};






/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Constants
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


/**
 * @namespace Default button configurations
 */
TableTools.BUTTONS = {
	"csv": {
		"sAction": "flash_save",
		"sCharSet": "utf8",
		"bBomInc": false,
		"sFileName": "*.csv",
		"sFieldBoundary": "",
		"sFieldSeperator": ";",
		"sNewLine": "auto",
		"sTitle": "",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_csv nuvola-icon ui-nuvola-doc-table",
		"sButtonClassHover": "DTTT_button_csv_hover nuvola-icon ui-nuvola-doc-table",
		"sButtonText": "CSV",
		"mColumns": "all", /* "all", "visible", "hidden" or array of column integers */
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig, flash ) {
			this.fnSetText( flash, this.fnGetTableData(oConfig) );
		},
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null
	},
	"xls": {
		"sAction": "flash_save",
		"sCharSet": "utf16le",
		"bBomInc": true,
		"sFileName": "*.xls",
		"sFieldBoundary": "",
		"sFieldSeperator": ";",
		"sNewLine": "auto",
		"sTitle": "",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_xls nuvola-icon ui-nuvola-xls-1",
		"sButtonClassHover": "DTTT_button_xls_hover nuvola-icon ui-nuvola-xls-1",
		"sButtonText": "Excel",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig, flash ) {
			this.fnSetText( flash, this.fnGetTableData(oConfig) );
		},
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null
	},
	"html": {
		"sAction": "flash_save",
		"sCharSet": "utf16le",
		"bBomInc": true,
		"sFileName": "*.html",
		"sFieldBoundary": "",
		"sFieldSeperator": ";",
		"sNewLine": "auto",
		"sTitle": "",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_html nuvola-icon ui-nuvola-file-html",
		"sButtonClassHover": "DTTT_button_html_hover nuvola-icon ui-nuvola-file-html",
		"sButtonText": "Exportar como HTML",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig, flash ) {
			this.fnSetText( flash, this._fnGetAsHTML(oConfig) );
		},
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null
	},
	"copy": {
		"sAction": "flash_copy",
		"sFieldBoundary": "",
		"sFieldSeperator": "\t",
		"sNewLine": "auto",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_copy nuvola-icon ui-nuvola-paste-bw",
		"sButtonClassHover": "DTTT_button_copy 	nuvola-icon ui-nuvola-paste-bw",
		"sButtonText": "Copiar al Portapapeles",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig, flash ) {
			this.fnSetText( flash, this.fnGetTableData(oConfig) );
		},
		"fnSelect": null,
		"fnComplete": function(nButton, oConfig, flash, text) {
			var
				len = text.split('\n').length - 1,
				plural = (len==1) ? "" : "s";
			jAlert( 'Copied '+len+' row'+plural+' to the clipboard' );
		},
		"fnInit": null
	},
	"pdf": {
		"sAction": "flash_pdf",
		"sFieldBoundary": "",
		"sFieldSeperator": "\t",
		"sNewLine": "\n",
		"sFileName": "*.pdf",
		"sToolTip": "",
		"sTitle": "",
		"sButtonClass": "DTTT_button_pdf nuvola-icon ui-nuvola-pdf",
		"sButtonClassHover": "DTTT_button_pdf_hover nuvola-icon ui-nuvola-pdf",
		"sButtonText": "Exportar como PDF",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig, flash ) {
			this.fnSetText( flash, 
				"title:"+ this.fnGetTitle(oConfig) +"\n"+
				"colWidth:"+ this.fnCalcColRatios(oConfig) +"\n"+
				"--/TableToolsOpts--\n" +
				this.fnGetTableData(oConfig)
			);
		},
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null
	},
	"print": {
		"sAction": "print",
		"sInfo": "<h6>Print view</h6><p>Please use your browser's print function to "+
		  "print this table. Press escape when finished.",
		"sMessage": "",
		"bShowAll": true,
		"sToolTip": "Ver Vista de Impresion",
		"sButtonClass": "DTTT_button_print nuvola-icon ui-nuvola-printer",
		"sButtonClassHover": "DTTT_button_print_hover nuvola-icon ui-nuvola-printer",
		"sButtonText": "Imprimir",
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": null,
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null
	},
	"text": {
		"sAction": "text",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_text",
		"sButtonClassHover": "DTTT_button_text_hover",
		"sButtonText": "Text button",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": null,
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null
	},
	"select": {
		"sAction": "text",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_text",
		"sButtonClassHover": "DTTT_button_text_hover",
		"sButtonText": "Seleccionar boton",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": null,
		"fnSelect": function( nButton, oConfig ) {
			if ( this.fnGetSelected().length !== 0 ) {
				$(nButton).removeClass('DTTT_disabled');
			} else {
				$(nButton).addClass('DTTT_disabled');
			}
		},
		"fnComplete": null,
		"fnInit": function( nButton, oConfig ) {
			$(nButton).addClass('DTTT_disabled');
		}
	},
	"select_single": {
		"sAction": "text",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_text",
		"sButtonClassHover": "DTTT_button_text_hover",
		"sButtonText": "Select button",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": null,
		"fnSelect": function( nButton, oConfig ) {
			var iSelected = this.fnGetSelected().length;
			if ( iSelected == 1 ) {
				$(nButton).removeClass('DTTT_disabled');
			} else {
				$(nButton).addClass('DTTT_disabled');
			}
		},
		"fnComplete": null,
		"fnInit": function( nButton, oConfig ) {
			$(nButton).addClass('DTTT_disabled');
		}
	},
	"select_all": {
		"sAction": "text",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_text",
		"sButtonClassHover": "DTTT_button_text_hover",
		"sButtonText": "Seleccionar Todos",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig ) {
			this.fnSelectAll();
		},
		"fnSelect": function( nButton, oConfig ) {
			if ( this.fnGetSelected().length == this.s.dt.fnRecordsDisplay() ) {
				$(nButton).addClass('DTTT_disabled');
			} else {
				$(nButton).removeClass('DTTT_disabled');
			}
		},
		"fnComplete": null,
		"fnInit": null
	},
	"select_none": {
		"sAction": "text",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_text",
		"sButtonClassHover": "DTTT_button_text_hover",
		"sButtonText": "Deseleccionar todos",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig ) {
			this.fnSelectNone();
		},
		"fnSelect": function( nButton, oConfig ) {
			if ( this.fnGetSelected().length !== 0 ) {
				$(nButton).removeClass('DTTT_disabled');
			} else {
				$(nButton).addClass('DTTT_disabled');
			}
		},
		"fnComplete": null,
		"fnInit": function( nButton, oConfig ) {
			$(nButton).addClass('DTTT_disabled');
		}
	},
	"ajax": {
		"sAction": "text",
		"sFieldBoundary": "",
		"sFieldSeperator": "\t",
		"sAjaxUrl": "/xhr.php",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_text",
		"sButtonClassHover": "DTTT_button_text_hover",
		"sButtonText": "Ajax button",
		"mColumns": "all",
		"bHeader": true,
		"bFooter": true,
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig ) {
			var sData = this.fnGetTableData(oConfig);
			$.ajax( {
				"url": oConfig.sAjaxUrl,
				"data": [
					{ "name": "tableData", "value": sData }
				],
				"success": oConfig.fnAjaxComplete,
				"dataType": "json",
				"type": "POST", 
				"cache": false,
				"error": function () {
					alert( "Error detected when sending table data to server" );
				}
			} );
		},
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null,
		"fnAjaxComplete": function( json ) {
			alert( 'Ajax complete' );
		}
	},
	"collection": {
		"sAction": "collection",
		"sToolTip": "",
		"sButtonClass": "DTTT_button_collection",
		"sButtonClassHover": "DTTT_button_collection_hover",
		"sButtonText": "Collection",
		"fnMouseover": null,
		"fnMouseout": null,
		"fnClick": function( nButton, oConfig ) {
			this._fnCollectionShow(nButton, oConfig);
		},
		"fnSelect": null,
		"fnComplete": null,
		"fnInit": null
	}
};
/*
 *  on* callback parameters:
 *  	1. node - button element
 *  	2. object - configuration object for this button
 *  	3. object - ZeroClipboard reference (flash button only)
 *  	4. string - Returned string from Flash (flash button only - and only on 'complete')
 */


/**
 * @namespace TableTools default settings for initialisation
 */
TableTools.DEFAULTS = {
	"sSwfPath":         "./templates/_public/swf/copy_cvs_xls_pdf.swf",
	"sRowSelect":       "none",
	"fnPreRowSelect":   null,
	"fnRowSelected":    null,
	"fnRowDeselected":  null,
	"aButtons":         [ "print","copy",  {"sExtends":"collection","sButtonText":"Exportar","sButtonClass":"DTTT_button_export nuvola-icon ui-nuvola-export-3","sButtonClassHover":"DTTT_button_export nuvola-icon ui-nuvola-export-3","aButtons":["xls","html","pdf"]}]
};


/**
 * Name of this class
 *  @constant CLASS
 *  @type     String
 *  @default  TableTools
 */
TableTools.prototype.CLASS = "TableTools";


/**
 * TableTools version
 *  @constant  VERSION
 *  @type      String
 *  @default   2.0.0
 */
TableTools.VERSION = "2.0.0";
TableTools.prototype.VERSION = TableTools.VERSION;




/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Initialisation
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/*
 * Register a new feature with DataTables
 */
if ( typeof $.fn.dataTable == "function" &&
     typeof $.fn.dataTableExt.fnVersionCheck == "function" &&
     $.fn.dataTableExt.fnVersionCheck('1.7.0') )
{
	$.fn.dataTableExt.aoFeatures.push( {
		"fnInit": function( oDTSettings ) {
			var oOpts = {};
			if(oDTSettings.oInit != null && typeof oDTSettings.oInit.oTableTools != 'undefined')
				oOpts = oDTSettings.oInit.oTableTools;
			
			var oTT = new TableTools( oDTSettings.oInstance, oOpts );
			TableTools._aInstances.push( oTT );
			
			return oTT.dom.container;
		},
		"cFeature": "T",
		"sFeature": "TableTools"
	} );
}
else
{
	alert( "Warning: TableTools 2 requires DataTables 1.7 or greater - www.datatables.net/download");
}

})(jQuery, window, document);
