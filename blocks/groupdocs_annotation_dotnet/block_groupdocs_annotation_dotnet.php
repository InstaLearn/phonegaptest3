<?php
// This file is part of GroupDocs Annotation for .NET plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing GroupDocs block instances.
 *
 * @package   block_groupdocs_annotation_dotnet
 */
class block_groupdocs_annotation_dotnet extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_groupdocs_annotation_dotnet');
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function specialization() {
        $this->title = isset($this->config->title) ? format_string($this->config->title) : format_string(get_string('newhtmlblock',
                'block_groupdocs_annotation_dotnet'));
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function get_content() {
        global $CFG, $USER, $DB;

        require_once($CFG->libdir . '/filelib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        $filteropt = new stdClass;
        $filteropt->overflowdiv = true;
        if ($this->content_is_trusted()) {
            // Fancy html allowed only on course, category and system blocks.
            $filteropt->noclean = true;
        }

        $this->content = new stdClass;
        $this->content->footer = '';
        if (isset($this->config->text)) {
            // Rewrite url.
            $this->config->text = file_rewrite_pluginfile_urls($this->config->text, 'pluginfile.php',
                    $this->context->id, 'block_gdocs_annotation_dotnet', 'content', null);

            // Default to FORMAT_HTML which is what will have been used before the.
            // Editor was properly implemented for the block.
            $format = FORMAT_HTML;
            // Check to see if the format has been properly set on the config.
            if (isset($this->config->format)) {
                $format = $this->config->format;
            }
            $this->content->text = format_text($this->config->text, $format, $filteropt);
        } else {
            $this->content->text = '';
        }

        unset($filteropt); // Memory footprint.

        return $this->content;
    }

    /**
     * Serialize and store config data
     */
    public function instance_config_save($data, $nolongerused = false) {
        global $DB, $USER;
        // Default values.
        $path = '';
        $groupdocsurl = '';
        $txt = '';

        // Form sent.
        if (!empty($_POST)) {

            $title = optional_param('config_title', '', PARAM_TEXT);
            $usr = $DB->get_record('block_gdocs_annotation_net', array('userid' => $USER->id));
            $groupdocsurl = optional_param('groupdocs_url', '', PARAM_TEXT);
            $path = optional_param('groupdocs_path', '', PARAM_PATH);
            $height = optional_param('height', 300, PARAM_INT);
            $width = optional_param('width', 600, PARAM_INT);
            $handler = optional_param('handler', null, PARAM_BOOL);
            $username = $USER->username;
            if ($width == 0) {
                $width = "650";
            }
            if ($height == 0) {
                $height = "500";
            }
            if ($handler == true) {
                $handler = "Handler";
                $use = true;
                $ajaxpath = $groupdocsurl . "/ajax.ashx/" . $username;
                $postdata = "";
            } else {
                $handler = "";
                $use = false;
                $ajaxpath = $groupdocsurl . "/home/getId/";
                $postdata = "un=" . $username;
            }
            // Insert groupdocs.
            if ($groupdocsurl) {

                if (substr($groupdocsurl, -1) == '/') {
                    $groupdocsurl = substr_replace($groupdocsurl, "", -1);
                }
                $url = $groupdocsurl . "/document-viewer/GetScript" . $handler . "?name=libs/jquery-ui-1.10.3.min.js";
                $headers = get_headers($url, 1);
                if ($headers[0] == 'HTTP/1.1 200 OK') {
                    $content = '';
                    // Standard embedding.
                    $txt = "<script src='" . $groupdocsurl . "/Scripts/jquery-1.10.2.min.js' type='text/javascript'></script>
                            <script src='" . $groupdocsurl . "/Scripts/jquery-ui-1.10.3.min.js' type='text/javascript'></script>
                            <script type='text/javascript' src='" . $groupdocsurl . "/document-viewer/GetScript" . $handler .
                            "?name=libs/jquery-1.9.1.min.js'></script>
                            <script type='text/javascript' src='" . $groupdocsurl . "/document-viewer/GetScript" . $handler .
                            "?name=libs/jquery-ui-1.10.3.min.js'></script>
                            <script type='text/javascript' src='" . $groupdocsurl . "/document-viewer/GetScript" . $handler .
                            "?name=libs/knockout-3.0.0.js'></script>
                            <script type='text/javascript' src='" . $groupdocsurl . "/document-viewer/GetScript" . $handler .
                            "?name=libs/turn.min.js'></script>"
                            . "<script type='text/javascript' src='" . $groupdocsurl . "/document-viewer/GetScript" . $handler .
                            "?name=libs/modernizr.2.6.2.Transform2d.min.js'></script>"
                            . "<script type='text/javascript'>if (!window.Modernizr.csstransforms)   $.ajax({url: '" .
                            $groupdocsurl . "/document-viewer/GetScript" . $handler . "?name=libs/turn.html4.min.js', "
                            . "dataType: 'script', type: 'GET', async: false});</script>"
                            . "<script type='text/javascript' src='" . $groupdocsurl . "/document-viewer/GetScript" . $handler .
                            "?name=installableViewer.min.js'></script>"
                            . "<script type='text/javascript'>$.ui.groupdocsViewer.prototype.applicationPath = '" .
                            $groupdocsurl . "/';</script>"
                            . "<script type='text/javascript'>$.ui.groupdocsViewer.prototype.useHttpHandlers = " . $use
                            . ";</script>"
                            . "<script type='text/javascript' src='" . $groupdocsurl . "/document-viewer/GetScript" .
                            $handler .
                            "?name=GroupdocsViewer.all.min.js'></script>"
                            . "<link rel='stylesheet' type='text/css' href='" . $groupdocsurl . "/document-viewer/CSS/GetCss" .
                            $handler . "?name=bootstrap.css' />"
                            . "<link rel='stylesheet' type='text/css' href='" . $groupdocsurl . "/document-viewer/CSS/GetCss"
                            . $handler . "?name=GroupdocsViewer.all.min.css' />"
                            . "<link rel='stylesheet' type='text/css' href='" . $groupdocsurl . "/document-viewer/CSS/GetCss"
                            . $handler . "?name=jquery-ui-1.10.3.dialog.min.css' />
                            <script type='text/javascript' src='" . $groupdocsurl . "/document-annotation/GetScript" . $handler .
                            "?name=libs/jquery.signalR-1.1.2.min.js'></script>
                            <script type='text/javascript' src='" . $groupdocsurl . "/document-annotation/GetScript" . $handler .
                            "?name=libs/jquery.tinyscrollbar.min.js'></script>
                            <script type='text/javascript' src='" . $groupdocsurl . "/document-annotation/GetScript" . $handler .
                            "?name=GroupdocsAnnotation.all.min.js'></script>
                            <link rel='stylesheet' type='text/css' href='" . $groupdocsurl . "/document-annotation/CSS/GetCss"
                            . $handler . "?name=Annotation.css' />
                            <link rel='stylesheet' type='text/css' href='" . $groupdocsurl . "/document-annotation/CSS/GetCss"
                            . $handler . "?name=Toolbox.css' />
                            <script type='text/javascript' src='" . $groupdocsurl . "/signalr1_1_2/hubs'></script>
                            <script type='text/javascript'>
                                    var userName = '" . $username . "';
                                    //Send ajax request to set entered user as collaborator for document
                                    $.ajax({
                                        type: 'POST',
                                        url: '" . $ajaxpath . "',
                                        data: '" . $postdata . "',
                                        cache: false,
                                        async: true,
                                        success: function (userInfo){
                                            var userId = '';
                                            if (typeof userInfo === 'object') {
                                                userId = userInfo[0];
                                            } else {
                                                userId = userInfo
                                            }
                                            //All settings for integrated Annotation
                                            var annotationWidget = $('#annotation-widget').groupdocsAnnotation({
                                                width: 600,
                                                height: 800,
                                                fileId: '" . $path . "',
                                                docViewerId: 'annotation-widget-doc-viewer',
                                                quality: 90,
                                                enableRightClickMenu: false,
                                                showHeader: false,
                                                showZoom: true,
                                                showPaging: true,
                                                showPrint: false,
                                                showFileExplorer: true,
                                                showThumbnails: true,
                                                openThumbnails: false,
                                                zoomToFitWidth: false,
                                                zoomToFitHeight: false,
                                                initialZoom: 100,
                                                preloadPagesCount: 0,
                                                sideboarContainerSelector: 'div.comments_sidebar_wrapper',
                                                usePageNumberInUrlHash: false,
                                                textSelectionSynchronousCalculation: true,
                                                variableHeightPageSupport: true,
                                                useJavaScriptDocumentDescription: true,
                                                isRightPanelEnabled: true,
                                                createMarkup: true,
                                                use_pdf: 'true',
                                                _mode: 'annotatedDocument',
                                                selectionContainerSelector: \"[name='selection-content']\",
                                                graphicsContainerSelector: '.annotationsContainer',
                                                userName: userName,
                                                userId: userId,
                                                enabledTools: -1,
                                                enableSidePanel: true
                                            });
                                            var annotationsViewer = $(annotationWidget).groupdocsAnnotation('getViewer');
                                            var annotationsViewerVM=$(annotationsViewer).groupdocsAnnotationViewer('getViewModel');
                                            var commentModePanel = $(annotationWidget).find('div.embed_annotation_tools');
                                            commentModePanel.css('margin-right', 0);
                                            commentModePanel.draggable({
                                                scroll: false,
                                                handle: '.tools_dots',
                                                containment: 'body',
                                                appendTo: 'body'
                                            });
                                            $(annotationWidget).find('.tool_field').click(function () {
                                                var toolFields = $(annotationWidget).find('.tool_field');
                                                if (toolFields.hasClass('active')) {
                                                    $(toolFields.removeClass('active'));
                                                };
                                                $(this).addClass('active');
                                            });
                                            $(annotationWidget).find('.header_tools_icon').hover(

                                                function () {
                                                    $(this).find('.tooltip_on_hover').css('display', 'block');
                                                },

                                                function () {
                                                    $(this).find('.tooltip_on_hover').css('display', 'none');
                                            });

                                            $('#annotation-widget .comments_togle_btn').click(function () { flipPanels(true); });
                                            $(annotationWidget).find('.comments_scroll').tinyscrollbar({ sizethumb: 50 });
                                            $(annotationWidget).find('.comments_scroll_2').tinyscrollbar({ sizethumb: 50 });
                                            var annotationIconsWrapper = $(annotationWidget).find('.annotation_icons_wrapper');
                                            var annotationIconsWrapperParent = annotationIconsWrapper.parent()[0];
                                            var annotationIconsWrapperParentScrollTop;
                                            annotationsViewer.bind('onDocumentLoadComplete', function (e, data) {
                                                annotationsViewerVM.listAnnotations();
                                                annotationsViewerVM.setHandToolMode();
                                                annotationIconsWrapper.height($(annotationsViewer).find('.pages_container').height());
                                                annotationIconsWrapperParent.scrollTop = annotationIconsWrapperParentScrollTop;
                                            });
                                            annotationsViewer.bind('onDocViewScrollPositionSet', function (e, data) {
                                                annotationIconsWrapper.parent()[0].scrollTop = data.position;
                                            }.bind(this));
                                            annotationsViewer.bind('onBeforeScrollDocView onDocViewScrollPositionSet',function(e,data){
                                                if (annotationIconsWrapperParent.scrollTop != data.position) {
                                                    annotationIconsWrapperParent.scrollTop = data.position;
                                                    annotationIconsWrapperParentScrollTop = data.position;
                                                }
                                            }.bind(this))

                                            function flipPanels(togglePanels) {
                                                var docViewer = $(annotationsViewer)[0];
                                                var annotationIconsPanelVisible = $(annotationWidget).find('.comments_sidebar_collapsed').is(':visible');
                                                function setIconsPanelScrollTop() {
                                                    if (!annotationIconsPanelVisible)
                                                    annotationIconsWrapperParent.scrollTop = docViewer.scrollTop;
                                                }

                                                function redrawLinesAndCalculateZoom() {
                                                setIconsPanelScrollTop();
                                                    if (togglePanels) {
                                                        annotationsViewerVM.redrawConnectingLines(!annotationIconsPanelVisible);
                                                    } else {
                                                    annotationsViewerVM.resizePagesToWindowSize();
                                                        var selectableElement = annotationsViewerVM.getSelectable();
                                                        if (selectableElement != null) {
                                                            var selectable = (selectableElement.data('ui-dvselectable') ||
                                                                selectableElement.data('dvselectable'));
                                                            selectable.initStorage();
                                                        }

                                                    annotationsViewerVM.redrawWorkingArea();
                                                    }
                                                }

                                                if (togglePanels) {
                                                    if (!annotationIconsPanelVisible) {
                                                        redrawLinesAndCalculateZoom();
                                                    };
                                                    var setIntervalId = window.setInterval(function () {
                                                        setIconsPanelScrollTop();
                                                    }, 50);
                                                    $(annotationWidget).find('.comments_sidebar_collapsed').toggle('slide',
                                                        { direction: 'right' }, 400, function () {
                                                            clearInterval(setIntervalId);
                                                            setIconsPanelScrollTop();
                                                        });
                                                    $(annotationWidget).find('.comments_sidebar_expanded').toggle('slide',
                                                        { direction: 'right' }, 400,

                                                    function () {
                                                        if (annotationIconsPanelVisible)
                                                            redrawLinesAndCalculateZoom();
                                                        else
                                                            setIconsPanelScrollTop();
                                                            //window.setZoomWhenTogglePanel();
                                                        })

                                                } else {
                                                    redrawLinesAndCalculateZoom();
                                                    $(annotationWidget).find('.comments_scroll').tinyscrollbar_update('relative');
                                                    $(annotationWidget).find('.comments_scroll_2').tinyscrollbar_update('relative');
                                                }
                                            }

                                            $(window).resize(function () {
                                                flipPanels(false);
                                                resizeSidebar();
                                            });
                                            resizeSidebar();

                                            function resizeSidebar() {
                                                var containerHeight = $('#annotation-widget .doc_viewer').height();
                                                $(annotationWidget).find('.comments_content').css({ 'height': (containerHeight - 152) + 'px' });
                                                $(annotationWidget).find('.comments_scroll').css({ 'height': (containerHeight - 152) + 'px' });
                                                $(annotationWidget).find('.comments_scroll .viewport').css({ 'height': (containerHeight - 172) + 'px' });
                                                $(annotationWidget).find('.comments_sidebar_collapsed').css({ 'height': (containerHeight - 50) + 'px' });
                                                $(annotationWidget).find('.comments_scroll').tinyscrollbar_update('relative');
                                                $(annotationWidget).find('.comments_scroll_2').css({ 'height': (containerHeight - 152) + 'px' });
                                                $(annotationWidget).find('.comments_scroll_2 .viewport').css({ 'height': (containerHeight - 152) + 'px' });
                                                $(annotationWidget).find('.comments_scroll_2').tinyscrollbar_update('relative');
                                            }

                                            $('html').click(function () {
                                                if ($(annotationWidget).find('.dropdown_menu_button').hasClass('active')) {
                                                    $(annotationWidget).find('.dropdown_menu_button.active').next('.dropdown_menu').hide('blind', 'fast');
                                                    $(annotationWidget).find('.dropdown_menu_button.active').removeClass('active');
                                                }
                                            })

                                        }

                                    });
                                </script>
                                <div id='annotation-widget' class='groupdocs_viewer_wrapper grpdx' style='width:" .
                                    $width . "px;height:" . $height . "px;'>" . $content . "</div>";
                } else {
                    $content = "Please change \"Use HTTP Handler\" option in edit block form";
                    $txt = "<div id='annotationdotnet' style='width:" . $width . "px;height:" . $height .
                            "px;overflow:hidden;position:relative;margin-bottom:20px;background-color:gray;border:1px solid #ccc;'>" . $content . "</div>";
                }
            }
        }

        // Save data.
        if ($usr != false) {
            $DB->execute('UPDATE {block_gdocs_annotation_net} SET url="' . $groupdocsurl . '", path="' . $path . '", title="' .
                    $title . '", width="' . $width . '", height="' . $height . '", handler="' . $use . '" WHERE userid =' . $USER->id);
        } else {
            $DB->execute('INSERT INTO {block_gdocs_annotation_net} (userid, url, path, title, width, height, handler) VALUES (' .
                    $USER->id . ', "' . $groupdocsurl . '", "' . $path . '", "' . $title . '", "' . $width . '", "' . $height . '", "' . $use . '")');
        }
        // Save content in htmlarea.
        $data->text['text'] = ($txt) ? $txt : $data->text['text'];
        $config = clone($data);
        // Move embedded files into a proper filearea and adjust HTML links to match.
        $config->text = file_save_draft_area_files($data->text['itemid'], $this->context->id, 'block_groupdocs_annotation_dotnet',
                'content', 0, array('subdirs' => true), $data->text['text']);
        $config->format = $data->text['format'];

        parent::instance_config_save($config, $nolongerused);
    }

    public function instance_delete() {

        global $DB;
        $fs = get_file_storage();
        $fs->delete_area_files($this->context->id, 'block_groupdocs_annotation_dotnet');
        return true;
    }

    public function content_is_trusted() {

        global $SCRIPT;

        if (!$context = get_context_instance_by_id($this->instance->parentcontextid)) {

            return false;
        }

        // Find out if this block is on the profile page.
        if ($context->contextlevel == CONTEXT_USER) {

            if ($SCRIPT === '/my/index.php') {
                // This is exception - page is completely private, nobody else may see content there.
                // That is why we allow JS here.
                return true;
            } else {
                // No JS on public personal pages, it would be a big security issue.
                return false;
            }
        }

        return true;
    }

    /**
     * The block should only be dockable when the title of the block is not empty
     * and when parent allows docking.
     *
     * @return bool
     */
    public function instance_can_be_docked() {

        return (!empty($this->config->title) && parent::instance_can_be_docked());
    }

}
