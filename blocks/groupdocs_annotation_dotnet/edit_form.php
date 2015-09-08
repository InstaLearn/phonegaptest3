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
 * google reference: $mform->addElement.
 */
class block_groupdocs_annotation_dotnet_edit_form extends block_edit_form {

    // Config page annotation (mvc).
    protected function specific_definition($mform) {
        global $DB, $USER;

        // Get user Acc. detais.
        $usr = $DB->get_record('block_gdocs_annotation_net', array('userid' => $USER->id));

        // Fields for editing GroupDocs block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title.
        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_groupdocs_annotation_dotnet'),
                array('value' => ($usr->title) ? $usr->title : 'GroupDocs Annotation .NET', 'size' => 25));
        $mform->setType('config_title', PARAM_MULTILANG);

        // GroupDocs Acc Details.
        $mform->addElement('html', '<div style="margin-left:17%;">');
        $mform->addElement('html', '<span style="font-size:10pt; color:red;">Please enter URL for installed'
                . ' GroupDocs Annotation .NET '
                . 'and path for default document to annotate:</span>'
                . '<div style="background-color:#e5e5e5;padding:5px;border:3px double gray;'
                . 'width:525px;">');
        $mform->addElement('text', 'groupdocs_url', get_string('url', 'block_groupdocs_annotation_dotnet'),
                array('value' => $usr->url, 'size' => 50));
        $mform->addElement('checkbox', 'handler', get_string('handler', 'block_groupdocs_annotation_dotnet'));
        if ($usr->handler == true) {
            $mform->setDefault('handler', true);
        }
        $mform->addElement('text', 'groupdocs_path', get_string('path', 'block_groupdocs_annotation_dotnet'),
                array('value' => $usr->path, 'size' => 50));
        $mform->addElement('html', '</div>');

        // Height and Width.
        $mform->addElement('html', 'Document size:
            <div style="background-color:#e5e5e5;padding:5px;border:3px double gray;width:525px;">
            <center>
            <span style="font-size:8pt;">(default: height=500px;width=580px;)</span>
            </center>');
        $mform->addElement('text', 'height', get_string('height', 'block_groupdocs_annotation_dotnet'),
                array('value' => $usr->height));
        $mform->addElement('text', 'width', get_string('width', 'block_groupdocs_annotation_dotnet'),
                array('value' => $usr->width));
        $mform->addElement('html', '</div>');

        $mform->addElement('html', '</div>');

        // Editor.
        $editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'noclean' => true, 'context' => $this->block->context);

        // Textarea.
        $mform->addElement('editor', 'config_text', get_string('configcontent', 'block_groupdocs_annotation_dotnet'),
                null, $editoroptions);
        $mform->setType('config_text', PARAM_RAW); // XSS is prevented when printing the block contents and serving files.
    }

    public function set_data($defaults) {

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->text;
            $draftideditor = file_get_submitted_draft_itemid('config_text');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_text['text'] = file_prepare_draft_area($draftideditor, $this->block->context->id,
                    'block_groupdocs_annotation_dotnet', 'content', 0, array('subdirs' => true), $currenttext);
            $defaults->config_text['itemid'] = $draftideditor;
            $defaults->config_text['format'] = $this->block->config->format;
        } else {
            $text = '';
        }

        if (!$this->block->user_can_edit() && !empty($this->block->config->title)) {
            // If a title has been set but the user cannot edit it format it nicely.
            $title = $this->block->config->title;
            $defaults->config_title = format_string($title, true, $this->page->context);
            // Remove the title from the config so that parent::set_data doesn't set it.
            unset($this->block->config->title);
        }

        // Have to delete text here, otherwise parent::set_data will empty content of editor.
        unset($this->block->config->text);
        parent::set_data($defaults);
        // Restore $text.
        if (!isset($this->block->config)) {
            $this->block->config = new stdClass();
        }
        $this->block->config->text = $text;
        if (isset($title)) {
            // Reset the preserved title.
            $this->block->config->title = $title;
        }
    }

}
