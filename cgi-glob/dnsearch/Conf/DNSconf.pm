# +-------------------------------------------------------------------------+
# | Config for DNSearch (Denwer Search)                                     |
# +-------------------------------------------------------------------------+
# | Copyright � Anton Sushchev aka Ant <http://forum.dklab.ru/users/Ant/>   |
# +-------------------------------------------------------------------------+


package Conf::DNSconf;

# ����, � �������� ������� ������ (��� Win).
my $drive = chr( ( stat '.' )[ 0 ] + ord( 'A' ) );

################################################################################
#*******************************************************************************
#* ��������� DNSearch
#*

# ����� (��������) ��������� ����������.
# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

our $TMP_PATH = '/tmp/dnsearch';

# ���� ��� ������.
# ~~~~~~~~~~~~~~~~

# �������� ���������� ��� ������. �� ����� ������. ������ ������ ������� �� ���������� ������:
# ������ ������ => [ "�������� ����� � �����", "���� ��� ������", "���� ��� �������� � ����������" ],�
# �� ������ ������������ ���� �������� ����� �����. ������ �� ����, ��� ���������� ����� �����
# ����� �����-������ ��������� ������ (��� ������� ����������).
our %PATHS = (
	1 => [ "� ������� ������������"    , "/home/localhost/www/Docs/", "http://localhost/Docs/"         ],
	2 => [ "� �http://localhost/�"     , "/home/localhost/www/"     , "http://localhost"               ],
	3 => [ "� �$drive:/home/localhost�", "$drive:/home/localhost"   , "file:///$drive:/home/localhost" ],
	4 => [ "� �/home�"                 , "/home/"                   , "file:///$drive:\\home\\"        ],
	5 => [ "� �/usr�"                  , "/usr/"                    , "file:///$drive:/usr/"           ],
	6 => [ "� ����� ����� �$drive�"    , "/"                        , "file:///$drive:/"               ],
);

# ���������� ������.
# ~~~~~~~~~~~~~~~~~~

# ����� ����� �������� ���������� qr// (qr/^.*?\.shtml$/i).

# �������� ���������� � ������� �� ����� ������.
our @NO_SEARCH_DIR = ( 'cgi', 'cgi-bin', 'cgi-glob' );

# �������� ������ (��� ����������) � ������� ����� ������.
our @YES_SEARCH_FILE = ( '.htm', '.html', '.shtml', '.xhtml' );

# �������� ������ (��� ����������) � ������� �� ����� ������.
our @NO_SEARCH_FILE = ( );

# ������ ������.
# ~~~~~~~~~~~~~~

# ���������� ������������� �������� �� ����� �������� �� ���������� ����� ���
# ����������� � �����������. �������� ��������, ���������� ������ �����������
# � ���� (���� ��� �������), �, �������������, ��� ������� ����� �� �������,
# ��� ������ � ����� ����� �������� ��� �� �����. ���������� ���� ������.
our $RESULT_BORDER = 200;

# ���������� ����������� �� ���� ��������.
# �0� � ��� ������������� ������ (�������� �� �����).
our $RESULTS_PER_PAGE = 10;

# ����������� �����������.
# ~~~~~~~~~~~~~~~~~~~~~~~~

# �0� � ��������� ����������� �����������. �1� � ���������.
# ����� ��� �������� ������ � ���������, ���������� �������� ��� �����.
our $CACHE_YES = 1;

# ���� � �����, ��� ����� ������ ���. ��� �/� � �����!
our $CACHE_PATH = $TMP_PATH.'/cache';

# ����� � �����, ������� ��� ��������� ��������.
# �0� � ��� ��� ����������� �� ������� (������������ *��* �������������).
our $CACHE_MAX_TIME = 10;

# ����������� ������ ���� � ����������, �� ���������� ��������, �� ����� �����.
# �0� - ��� ��� ����������� �� ������� (������������ *��* �������������).
our $CACHE_MAX_SIZE = 10;

# ����������� �����.
# ~~~~~~~~~~~~~~~~~~

# �0� � ��������� ����������� �����. �1� � ���������.
our $PATHS_CACHE = 1;

# ���� � �����, ��� ����� ������ ���� � ��������������� ������. ��� �/� � �����!
our $PATHS_CACHE_PATH = $TMP_PATH;

# ����������� ������ ����� � ��������������� ������.
# ������ ����� ��, ��� � � $CACHE_MAX_SIZE.
our $PATHS_CACHE_MAX_SIZE = 10;

# ����� ����� $PATHS_CACHE.
# ������ ����� ��, ��� � � $CACHE_MAX_TIME.
our $PATHS_CACHE_MAX_TIME = 10;

# ������ � ��������.
# ~~~~~~~~~~~~~~~~~~

# �������� ����������, ������� ��������� ������� ��������.
# � ����� �Conf/archive.types� ���������� ���������� �
# ��������������� �� ���� � ����������� ��� ����������.
our @ARCHIVE_FILE = ( '.chm', '.zip', '.rar' );

# ������������ ������ ������� ��� ����������. � ����������.
# ���� ������ ������ �������� ��������, �� ����� ����������
# �� ����� (��������������, �� ����� �������� ��� ������).
# ���� �0�, �� ��� �����������.
our $ARCHIVE_FILE_MAX_SIZE = 5;

# ���� � �����, ��� ����� ������ ������������� �����. ��� �/� � �����!
# ����� ����� �� ���� ������ ���� ���������� � $VIEW_PATH � ����� �viewer.pl�.
our $ARCH_PATH = $TMP_PATH.'/arch';

# ����������� ������ ������������� �������.
# ������ ����� ��, ��� � � $CACHE_MAX_SIZE.
our $ARCH_MAX_SIZE = 80;

# ����������� �� ���������� ���������.
# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

# ������������ ���������� ���������, ������� ����� ������������ �����������.
# �0� � ��� �����������.
our $MAX_PROCESS_NUMBER = 0;

# ���� � �����, ��� ����� ������ ���� � �������������� ����������� ���������.
# ��� �/� � �����!
our $MAX_PROCESS_NUMBER_PATH = $TMP_PATH;

# ����� ����� $MAX_PROCESS_NUMBER_PATH.
# ������ ����� ��, ��� � � $CACHE_MAX_TIME.
our $MAX_PROCESS_NUMBER_TIME = 1;

#*
#* ����� �������� DNSearch
#*******************************************************************************
################################################################################

# ������������ ��� ������� � ��������� �����.
# ���������� �������������.
# � dk
sub import {
	while( my ( $k, $v ) = each( %{ __PACKAGE__."::" } ) ) {
		next if substr( $k , -1 ) eq ":" || grep { $k eq $_ } qw(BEGIN import);
		*{ caller()."::".$k } = $v;
	}
}

return 1;
