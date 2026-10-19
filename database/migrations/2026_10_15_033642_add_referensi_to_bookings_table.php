public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('referensi')->nullable()->after('telepon');
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('referensi');
    });
}