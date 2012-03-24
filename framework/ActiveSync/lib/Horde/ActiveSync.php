<?php
/**
 * ActiveSync Server - ported from ZPush
 *
 * Refactoring and other changes are
 * Copyright 2009-2012 Horde LLC (http://www.horde.org/)
 *
 * @author Michael J. Rubinsky <mrubinsk@horde.org>
 * @package ActiveSync
 */
/**
 * File      :   diffbackend.php
 * Project   :   Z-Push
 * Descr     :   We do a standard differential
 *               change detection by sorting both
 *               lists of items by their unique id,
 *               and then traversing both arrays
 *               of items at once. Changes can be
 *               detected by comparing items at
 *               the same position in both arrays.
 *
 * Created   :   01.10.2007
 *
 * Zarafa Deutschland GmbH, www.zarafaserver.de
 * This file is distributed under GPL-2.0.
 * Consult COPYING file for details
 */

// POOMMAIL

//
//// ResolveRecipients
//define("SYNC_RESOLVERECIPIENTS_RESOLVERECIPIENTS","ResolveRecipients:ResolveRecipients");
//define("SYNC_RESOLVERECIPIENTS_RESPONSE","ResolveRecipients:Response");
//define("SYNC_RESOLVERECIPIENTS_STATUS","ResolveRecipients:Status");
//define("SYNC_RESOLVERECIPIENTS_TYPE","ResolveRecipients:Type");
//define("SYNC_RESOLVERECIPIENTS_RECIPIENT","ResolveRecipients:Recipient");
//define("SYNC_RESOLVERECIPIENTS_DISPLAYNAME","ResolveRecipients:DisplayName");
//define("SYNC_RESOLVERECIPIENTS_EMAILADDRESS","ResolveRecipients:EmailAddress");
//define("SYNC_RESOLVERECIPIENTS_CERTIFICATES","ResolveRecipients:Certificates");
//define("SYNC_RESOLVERECIPIENTS_CERTIFICATE","ResolveRecipients:Certificate");
//define("SYNC_RESOLVERECIPIENTS_MINICERTIFICATE","ResolveRecipients:MiniCertificate");
//define("SYNC_RESOLVERECIPIENTS_OPTIONS","ResolveRecipients:Options");
//define("SYNC_RESOLVERECIPIENTS_TO","ResolveRecipients:To");
//define("SYNC_RESOLVERECIPIENTS_CERTIFICATERETRIEVAL","ResolveRecipients:CertificateRetrieval");
//define("SYNC_RESOLVERECIPIENTS_RECIPIENTCOUNT","ResolveRecipients:RecipientCount");
//define("SYNC_RESOLVERECIPIENTS_MAXCERTIFICATES","ResolveRecipients:MaxCertificates");
//define("SYNC_RESOLVERECIPIENTS_MAXAMBIGUOUSRECIPIENTS","ResolveRecipients:MaxAmbiguousRecipients");
//define("SYNC_RESOLVERECIPIENTS_CERTIFICATECOUNT","ResolveRecipients:CertificateCount");
//
//// ValidateCert
//define("SYNC_VALIDATECERT_VALIDATECERT","ValidateCert:ValidateCert");
//define("SYNC_VALIDATECERT_CERTIFICATES","ValidateCert:Certificates");
//define("SYNC_VALIDATECERT_CERTIFICATE","ValidateCert:Certificate");
//define("SYNC_VALIDATECERT_CERTIFICATECHAIN","ValidateCert:CertificateChain");
//define("SYNC_VALIDATECERT_CHECKCRL","ValidateCert:CheckCRL");
//define("SYNC_VALIDATECERT_STATUS","ValidateCert:Status");

/**
 * Main ActiveSync class. Entry point for performing all ActiveSync operations
 *
 */
class Horde_ActiveSync
{
    /* Conflict resolution */
    const CONFLICT_OVERWRITE_SERVER     = 0;
    const CONFLICT_OVERWRITE_PIM        = 1;

    /* Flag used to indicate we should NOT export change data to the PIM. Used
     * during PING requests. */
    const BACKEND_IGNORE_DATA          = 1;

    /* TRUNCATION Constants */
    const TRUNCATION_ALL                = 0;
    const TRUNCATION_1                  = 1;
    const TRUNCATION_2                  = 2;
    const TRUNCATION_3                  = 3;
    const TRUNCATION_4                  = 4;
    const TRUNCATION_5                  = 5;
    const TRUNCATION_6                  = 6;
    const TRUNCATION_7                  = 7;
    const TRUNCATION_8                  = 8;
    const TRUNCATION_NONE               = 9;

    /* Request related constants that are used in multiple places */
    /* FOLDERHIERARCHY */
    const FOLDERHIERARCHY_FOLDERS       = 'FolderHierarchy:Folders';
    const FOLDERHIERARCHY_FOLDER        = 'FolderHierarchy:Folder';
    const FOLDERHIERARCHY_DISPLAYNAME   = 'FolderHierarchy:DisplayName';
    const FOLDERHIERARCHY_SERVERENTRYID = 'FolderHierarchy:ServerEntryId';
    const FOLDERHIERARCHY_PARENTID      = 'FolderHierarchy:ParentId';
    const FOLDERHIERARCHY_TYPE          = 'FolderHierarchy:Type';
    const FOLDERHIERARCHY_RESPONSE      = 'FolderHierarchy:Response';
    const FOLDERHIERARCHY_STATUS        = 'FolderHierarchy:Status';
    const FOLDERHIERARCHY_CONTENTCLASS  = 'FolderHierarchy:ContentClass';
    const FOLDERHIERARCHY_CHANGES       = 'FolderHierarchy:Changes';
    const FOLDERHIERARCHY_SYNCKEY       = 'FolderHierarchy:SyncKey';
    const FOLDERHIERARCHY_FOLDERSYNC    = 'FolderHierarchy:FolderSync';
    const FOLDERHIERARCHY_COUNT         = 'FolderHierarchy:Count';
    const FOLDERHIERARCHY_VERSION       = 'FolderHierarchy:Version';

    /* SYNC */
    const SYNC_SYNCHRONIZE              = 'Synchronize';
    const SYNC_REPLIES                  = 'Replies';
    const SYNC_ADD                      = 'Add';
    const SYNC_MODIFY                   = 'Modify';
    const SYNC_REMOVE                   = 'Remove';
    const SYNC_FETCH                    = 'Fetch';
    const SYNC_SYNCKEY                  = 'SyncKey';
    const SYNC_CLIENTENTRYID            = 'ClientEntryId';
    const SYNC_SERVERENTRYID            = 'ServerEntryId';
    const SYNC_STATUS                   = 'Status';
    const SYNC_FOLDER                   = 'Folder';
    const SYNC_FOLDERTYPE               = 'FolderType';
    const SYNC_VERSION                  = 'Version';
    const SYNC_FOLDERID                 = 'FolderId';
    const SYNC_GETCHANGES               = 'GetChanges';
    const SYNC_MOREAVAILABLE            = 'MoreAvailable';
    const SYNC_WINDOWSIZE               = 'WindowSize';
    const SYNC_COMMANDS                 = 'Commands';
    const SYNC_OPTIONS                  = 'Options';
    const SYNC_FILTERTYPE               = 'FilterType';
    const SYNC_TRUNCATION               = 'Truncation';
    const SYNC_RTFTRUNCATION            = 'RtfTruncation';
    const SYNC_CONFLICT                 = 'Conflict';
    const SYNC_FOLDERS                  = 'Folders';
    const SYNC_DATA                     = 'Data';
    const SYNC_DELETESASMOVES           = 'DeletesAsMoves';
    const SYNC_NOTIFYGUID               = 'NotifyGUID';
    const SYNC_SUPPORTED                = 'Supported';
    const SYNC_SOFTDELETE               = 'SoftDelete';
    const SYNC_MIMESUPPORT              = 'MIMESupport';
    const SYNC_MIMETRUNCATION           = 'MIMETruncation';

    /* AIRSYNCBASE */
    const AIRSYNCBASE_BODYPREFERENCE    = 'AirSyncBase:BodyPreference';
    const AIRSYNCBASE_TYPE              = 'AirSyncBase:Type';
    const AIRSYNCBASE_TRUNCATIONSIZE    = 'AirSyncBase:TruncationSize';
    const AIRSYNCBASE_ALLORNONE         = 'AirSyncBase:AllOrNone';
    const AIRSYNCBASE_BODY              = 'AirSyncBase:Body';
    const AIRSYNCBASE_DATA              = 'AirSyncBase:Data';
    const AIRSYNCBASE_ESTIMATEDDATASIZE = 'AirSyncBase:EstimatedDataSize';
    const AIRSYNCBASE_TRUNCATED         = 'AirSyncBase:Truncated';
    const AIRSYNCBASE_ATTACHMENTS       = 'AirSyncBase:Attachments';
    const AIRSYNCBASE_ATTACHMENT        = 'AirSyncBase:Attachment';
    const AIRSYNCBASE_DISPLAYNAME       = 'AirSyncBase:DisplayName';
    const AIRSYNCBASE_FILEREFERENCE     = 'AirSyncBase:FileReference';
    const AIRSYNCBASE_METHOD            = 'AirSyncBase:Method';
    const AIRSYNCBASE_CONTENTID         = 'AirSyncBase:ContentId';
    const AIRSYNCBASE_CONTENTLOCATION   = 'AirSyncBase:ContentLocation';
    const AIRSYNCBASE_ISINLINE          = 'AirSyncBase:IsInline';
    const AIRSYNCBASE_NATIVEBODYTYPE    = 'AirSyncBase:NativeBodyType';
    const AIRSYNCBASE_CONTENTTYPE       = 'AirSyncBase:ContentType';
    const AIRSYNCBASE_PREVIEW           = 'AirSyncBase:Preview';

    /* Body type prefs */
    const BODYPREF_TYPE_PLAIN = 1;
    const BODYPREF_TYPE_HTML  = 2;
    const BODYPREF_TYPE_RTF   = 3;
    const BODYPREF_TYPE_MIME  = 4;

    /* PROVISION */
    const PROVISION_PROVISION           =  'Provision:Provision';
    const PROVISION_POLICIES            =  'Provision:Policies';
    const PROVISION_POLICY              =  'Provision:Policy';
    const PROVISION_POLICYTYPE          =  'Provision:PolicyType';
    const PROVISION_POLICYKEY           =  'Provision:PolicyKey';
    const PROVISION_DATA                =  'Provision:Data';
    const PROVISION_STATUS              =  'Provision:Status';
    const PROVISION_REMOTEWIPE          =  'Provision:RemoteWipe';
    const PROVISION_EASPROVISIONDOC     =  'Provision:EASProvisionDoc';

    /* Flags */
    const FLAG_NEWMESSAGE               = 'NewMessage';

    /* Folder types */
    const FOLDER_TYPE_OTHER             =  1;
    const FOLDER_TYPE_INBOX             =  2;
    const FOLDER_TYPE_DRAFTS            =  3;
    const FOLDER_TYPE_WASTEBASKET       =  4;
    const FOLDER_TYPE_SENTMAIL          =  5;
    const FOLDER_TYPE_OUTBOX            =  6;
    const FOLDER_TYPE_TASK              =  7;
    const FOLDER_TYPE_APPOINTMENT       =  8;
    const FOLDER_TYPE_CONTACT           =  9;
    const FOLDER_TYPE_NOTE              =  10;
    const FOLDER_TYPE_JOURNAL           =  11;
    const FOLDER_TYPE_USER_MAIL         =  12;
    const FOLDER_TYPE_USER_APPOINTMENT  =  13;
    const FOLDER_TYPE_USER_CONTACT      =  14;
    const FOLDER_TYPE_USER_TASK         =  15;
    const FOLDER_TYPE_USER_JOURNAL      =  16;
    const FOLDER_TYPE_USER_NOTE         =  17;
    const FOLDER_TYPE_UNKNOWN           =  18;
    const FOLDER_TYPE_RECIPIENT_CACHE   =  19;
    const FOLDER_TYPE_DUMMY             =  '__dummy.Folder.Id__';

    /** Origin of changes **/
    const CHANGE_ORIGIN_PIM             = 0;
    const CHANGE_ORIGIN_SERVER          = 1;
    const CHANGE_ORIGIN_NA              = 3;

    /** Remote wipe **/
    const RWSTATUS_NA                   = 0;
    const RWSTATUS_OK                   = 1;
    const RWSTATUS_PENDING              = 2;
    const RWSTATUS_WIPED                = 3;

    /** GAL **/
    const GAL_DISPLAYNAME               = 'GAL:DisplayName';
    const GAL_PHONE                     = 'GAL:Phone';
    const GAL_OFFICE                    = 'GAL:Office';
    const GAL_TITLE                     = 'GAL:Title';
    const GAL_COMPANY                   = 'GAL:Company';
    const GAL_ALIAS                     = 'GAL:Alias';
    const GAL_FIRSTNAME                 = 'GAL:FirstName';
    const GAL_LASTNAME                  = 'GAL:LastName';
    const GAL_HOMEPHONE                 = 'GAL:HomePhone';
    const GAL_MOBILEPHONE               = 'GAL:MobilePhone';
    const GAL_EMAILADDRESS              = 'GAL:EmailAddress';

    /* Request Type */
    const REQUEST_TYPE_SYNC             = 'sync';
    const REQUEST_TYPE_FOLDERSYNC       = 'foldersync';

    /* Change Type */
    const CHANGE_TYPE_CHANGE            = 'change';
    const CHANGE_TYPE_DELETE            = 'delete';
    const CHANGE_TYPE_FLAGS             = 'flags';
    const CHANGE_TYPE_MOVE              = 'move';
    const CHANGE_TYPE_FOLDERSYNC        = 'foldersync';

    /* Collection Classes */
    const CLASS_EMAIL    = 'Email';
    const CLASS_CONTACTS = 'Contacts';
    const CLASS_CALENDAR = 'Calendar';
    const CLASS_TASKS    = 'Tasks';

    /* Filtertype constants */
    const FILTERTYPE_ALL     = 0;
    const FILTERTYPE_1DAY    = 1;
    const FILTERTYPE_3DAYS   = 2;
    const FILTERTYPE_1WEEK   = 3;
    const FILTERTYPE_2WEEKS  = 4;
    const FILTERTYPE_1MONTH  = 5;
    const FILTERTYPE_3MONTHS = 6;
    const FILTERTYPE_6MONTHS = 7;

    const PROVISIONING_FORCE            = true;
    const PROVISIONING_LOOSE            = 'loose';
    const PROVISIONING_NONE             = false;

    const FOLDER_ROOT                   = 0;

    const VERSION_TWOFIVE  = 2.5;
    const VERSION_TWELVE   = 12;

    /**
     * Logger
     *
     * @var Horde_Log_Logger
     */
    protected $_logger;

    /**
     * Provisioning support
     *
     * @var string (TODO _constant this)
     */
    protected $_provisioning;

    /**
     * Highest version to support.
     *
     * @var float
     */
    protected $_maxVersion = self::VERSION_TWOFIVE;//self::VERSION_TWELVE;

    /**
     * The actual version we are supporting.
     *
     * @var float
     */
    protected $_version;

    /**
     * Multipart support?
     *
     * @var boolean
     */
    protected $_multipart = false;

    /**
     * Support gzip compression of certain data parts?
     *
     * @var boolean
     */
    protected $_compression = false;

    /**
     * Const'r
     *
     * @param Horde_ActiveSync_Driver_Base $driver      The backend driver.
     * @param Horde_ActiveSync_Wbxml_Decoder $decoder   The Wbxml decoder.
     * @param Horde_ActiveSync_Wbxml_Endcoder $encoder  The Wbxml encoder.
     * @param Horde_ActiveSync_State_Base $state        The state driver.
     * @param Horde_Controller_Request_Http $request    The HTTP request object.
     *
     * @return Horde_ActiveSync
     */
    public function __construct(
        Horde_ActiveSync_Driver_Base $driver,
        Horde_ActiveSync_Wbxml_Decoder $decoder,
        Horde_ActiveSync_Wbxml_Encoder $encoder,
        Horde_ActiveSync_State_Base $state,
        Horde_Controller_Request_Http $request)
    {
        // The http request
        $this->_request = $request;

        // Backend driver
        $this->_driver = $driver;
        $this->_driver->setProtocolVersion($this->getProtocolVersion());

        // Device state manager
        $this->_state = $state;

        // Wbxml handlers
        $this->_encoder = $encoder;
        $this->_decoder = $decoder;

        // Read the initial Wbxml header
        $this->_decoder->readWbxmlHeader();
    }

    /**
     * Allow to force the highest version to support.
     *
     * @param float $version  The highest version
     */
    public function setSupportedVersion($version)
    {
        $this->_maxVersion = $version;
    }

    /**
     * Getter
     *
     * @param string $property  The property to return.
     *
     * @return mixed  The value of the requested property.
     */
    public function __get($property)
    {
        switch ($property) {
        case 'encoder':
        case 'decoder':
        case 'state':
        case 'request':
        case 'driver':
        case 'provisioning':
            $property = '_' . $property;
            return $this->$property;
        default:
            throw new InvalidArgumentException(sprintf(
                'The property %s does not exist',
                $property)
            );
        }
    }

    /**
     * Setter for the logger
     *
     * @param Horde_Log_Logger $logger  The logger object.
     *
     * @return void
     */
    public function setLogger(Horde_Log_Logger $logger)
    {
        $this->_logger = $logger;
        $this->_encoder->setLogger($logger);
        $this->_decoder->setLogger($logger);
        $this->_driver->setLogger($logger);
        $this->_state->setLogger($logger);
    }

    /**
     * Setter for provisioning support
     *
     */
    public function setProvisioning($provision)
    {
        $this->_provisioning = $provision;
    }

    public function provisioningRequired()
    {
        self::provisionHeader();
        $this->activeSyncHeader();
        $this->versionHeader();
        $this->commandsHeader();
        header("Cache-Control: private");
    }

    /**
     * The heart of the server. Dispatch a request to the appropriate request
     * handler.
     *
     * @param string $cmd    The command we are requesting.
     * @param string $devId  The device id making the request.
     *
     * @return string|boolean  false if failed, true if succeeded and response
     *                         content is wbxml, otherwise the
     *                         content-type string to send in the response.
     * @throws Horde_ActiveSync_Exception, Horde_ActiveSync_Exception_InvalidRequest
     */
    public function handleRequest($cmd, $devId)
    {
        $this->_logger->debug(sprintf(
            "[%s] %s request received for user %s",
            $devId,
            strtoupper($cmd),
            $this->_driver->getUser())
        );

        // Don't bother with everything else if all we want are Options
        if ($cmd == 'Options') {
            $this->activeSyncHeader();
            $this->versionHeader();
            $this->commandsHeader();
            return true;
        }

        // These are all handled in the same class.
        if ($cmd == 'FolderDelete' || $cmd == 'FolderUpdate') {
            $cmd = 'FolderCreate';
        }

        // Device id is REQUIRED
        if (is_null($devId)) {
            throw new Horde_ActiveSync_Exception_InvalidRequest('Device failed to send device id.');
        }

        // Does device exist AND does the user have an account on the device?
        if (!empty($devId) && !$this->_state->deviceExists($devId, $this->_driver->getUser())) {
            // Device might exist, but with a new (additional) user account
            $device = new StdClass();
            if ($this->_state->deviceExists($devId)) {
                $d = $this->_state->loadDeviceInfo($devId, '');;
            }
            $device->policykey = 0;
            $get = $this->_request->getGetVars();
            $device->userAgent = $this->_request->getHeader('User-Agent');
            $device->deviceType = !empty($get['DeviceType']) ? $get['DeviceType'] : '';
            $device->rwstatus = self::RWSTATUS_NA;
            $device->user = $this->_driver->getUser();
            $device->id = $devId;
            $this->_state->setDeviceInfo($device);
        } else {
            $device = $this->_state->loadDeviceInfo($devId, $this->_driver->getUser());
        }

        // Support Multipart response for ITEMOPERATIONS requests?
        $this->_multipart = $this->_request->getHeader('MS-ASAcceptMultiPart') == 'T';

        // Support gzip encoding?
        // We have to manage it ourselves, since only portions of the data
        // are expected to be encoded.

        // Load the request handler to handle the request
        // We must send the eas header here, since some requests may start
        // output and be large enough to flush the buffer (e.g., GetAttachement)
        Horde_ActiveSync::activeSyncHeader();
        $class = 'Horde_ActiveSync_Request_' . basename($cmd);
        $version = $this->getProtocolVersion();
        if (class_exists($class)) {
            $request = new $class($this, $device);
            $request->setLogger($this->_logger);
            $result = $request->handle();
            $this->_driver->logOff();

            return $result;
        }

        throw new Horde_ActiveSync_Exception_InvalidRequest(basename($cmd) . ' not supported.');
    }

    /**
     * Send the MS_Server-ActiveSync header.
     *
     */
    public function activeSyncHeader()
    {
        switch ($this->_maxVersion) {
        case self::VERSION_TWOFIVE:
        case self::VERSION_TWELVE:
            header("MS-Server-ActiveSync: 6.5.7638.1");
            break;
        }
    }

    /**
     * Send the protocol versions header.
     *
     */
    public function versionHeader()
    {
        switch ($this->_maxVersion) {
        case self::VERSION_TWOFIVE:
            header("MS-ASProtocolVersions: 1.0,2.0,2.1,2.5");
            break;
        case self::VERSION_TWELVE:
            header("MS-ASProtocolVersions: 1.0,2.0,2.1,2.5,12.0");
        }
    }

    /**
     * Send protocol commands header.
     *
     */
    public function commandsHeader()
    {
        switch ($this->_maxVersion) {
        case self::VERSION_TWOFIVE:
            header("MS-ASProtocolCommands: Sync,SendMail,SmartForward,SmartReply,GetAttachment,GetHierarchy,CreateCollection,DeleteCollection,MoveCollection,FolderSync,FolderCreate,FolderDelete,FolderUpdate,MoveItems,GetItemEstimate,MeetingResponse,ResolveRecipients,ValidateCert,Provision,Search,Ping");
            break;
        case self::VERSION_TWELVE:
            header("MS-ASProtocolCommands: Sync,SendMail,SmartForward,SmartReply,GetAttachment,GetHierarchy,CreateCollection,DeleteCollection,MoveCollection,FolderSync,FolderCreate,FolderDelete,FolderUpdate,MoveItems,GetItemEstimate,MeetingResponse,ResolveRecipients,ValidateCert,Provision,Settings,Search,Ping,ItemOperations");
            break;
        }
    }

    /**
     * Send provision header
     *
     */
    static public function provisionHeader()
    {
        header("HTTP/1.1 449 Retry after sending a PROVISION command");
    }

    /**
     * Obtain the policy key header from the request.
     *
     * @return integer  The policy key or '0' if not set.
     */
    public function getPolicyKey()
    {
        $this->_policykey = $this->_request->getHeader('X-MS-PolicyKey');
        if (empty($this->_policykey)) {
            $this->_policykey = 0;
        }

        return $this->_policykey;
    }

    /**
     * Obtain the ActiveSync protocol version
     *
     * @return string
     */
    public function getProtocolVersion()
    {
        if (isset($this->_version)) {
            return $this->_version;
        }
        $this->_version = $this->_request->getHeader('MS-ASProtocolVersion');
        if (empty($this->_version)) {
            $this->_version = '1.0';
        }

        return $this->_version;
    }

    /**
     *
     * @param $truncation
     * @return unknown_type
     */
    static public function getTruncSize($truncation)
    {
        switch($truncation) {
        case Horde_ActiveSync::TRUNCATION_ALL:
            return 0;
        case Horde_ActiveSync::TRUNCATION_1:
            return 512;
        case Horde_ActiveSync::TRUNCATION_2:
            return 1024;
        case Horde_ActiveSync::TRUNCATION_3:
            return 2048;
        case Horde_ActiveSync::TRUNCATION_4:
            return 5120;
        // case Horde_ActiveSync::TRUNCATION_5:
        //     return 20480;
        // case Horde_ActiveSync::TRUNCATION_6:
        //     return 51200;
        case Horde_ActiveSync::TRUNCATION_7:
            //return 102400;
        //case Horde_ActiveSync::TRUNCATION_8:
        case Horde_ActiveSync::TRUNCATION_NONE:
            return 1048576; // We'll limit to 1MB anyway
        default:
            return 1024; // Default to 1Kb
        }
    }

}