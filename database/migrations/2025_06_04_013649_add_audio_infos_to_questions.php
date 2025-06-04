<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAudioInfosToQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oex_question_masters', function (Blueprint $table) {
            $table->string('audio_file')->nullable()->after('questions');
            $table->string('audio_path')->nullable()->after('audio_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oex_question_masters', function (Blueprint $table) {
            $table->dropColumn(['audio_file', 'audio_path']);
        });
    }
}
