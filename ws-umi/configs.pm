#!/usr/bin/perl -w

package configs;
	use DBI;
    use POSIX qw( strftime );
	use File::Spec;
	use strict;

    BEGIN {
		use Exporter();
		our (@ISA, @EXPORT);

		@ISA = qw (Exporter);
		@EXPORT = qw (%var);
	}
	our %var = ();
	my $entityDir = File::Spec->catfile( File::Spec->rel2abs( File::Spec->curdir() ), 'entity.inc');

    # load configuration file as hash
	my ($config, $name, $value);
	my (@contents);

	open(FH, $entityDir) || die "Can't open $entityDir: $!\n";
	@contents = <FH>;
	close FH;
	foreach $config (@contents)	{
		chomp($config);
		next if ( ($config eq '') || ($config =~ /^#/) );
		($name, $value) = ($config =~ /^\s*(\S+)\s*=\s*(.*)/g);
		$var{$name} = $value;
	}
    
    
	sub ConnectDB {
		# subroutine to connect to database, returning database handle
		my ($this) = @_;
        my ($DSN);
        if ($var{'DBTYPE'} eq 'MSSQL'){
            $DSN = "driver={SQL Server};server=$var{'DBHOST'};database=$var{'DBNAME'};";
            $DSN = "DBI:ODBC:$DSN";
        } 
        elsif ($var{'DBTYPE'} eq 'POSTGRESQL'){ $DSN = "DBI:Pg:dbname=$var{'DBNAME'};host=$var{'DBHOST'};port=$var{'DBPORT'}";
        } 
        else { $DSN = "DBI:$var{'DBTYPE'}:database=$var{'DBNAME'};host=$var{'DBHOST'}";  }

		my $dbh = DBI->connect($DSN, $var{'DBUSER'}, $var{'DBPASS'}, { AutoCommit => 0, PrintError => 0, RaiseError => 1 }) || die $DBI::errstr;
		return $dbh;
	}

	sub ExecQuery {
		# subroutine to execute given query, and return statement handle
		my ($this, $dbh, $sql) = @_;
		my $sth = $dbh->prepare($sql);

		if (! $sth) { return 0; }
		if (! $sth->execute) { return 0; }
		$sth->{'ChopBlanks'} = 1;
		return $sth;
	}

    sub WriteLog {
        my ($this, $typelog, $msg) = @_;
        my $ts = strftime("%Y-%m-%d %H:%M:%S", localtime) ;

        my $logFile = File::Spec->catfile($var{'logDir'});
        close STDOUT;
        open(STDOUT, '>>', $logFile);
        select STDOUT; $| = 1;
        if (1) { 
            print STDOUT $ts . ";" . $typelog . ";" . $msg . "\n";
        }
        return 1;
    }
1;
