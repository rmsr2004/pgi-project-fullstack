#!/bin/bash

# SFTP connection configuration
HOST='avosdaluguer.dei.uc.pt'
USER='rodrigorodrigues'
PASSWD='Rrodrigues23'
REMOTE_DIR='/home/rodrigorodrigues/avosdaluguer.dei.uc.pt/public_html'
LOCAL_DIR="$(dirname "$(realpath "$0")")"

# check if LOCAL_DIR exists
if [ ! -d "$LOCAL_DIR" ]; then
    echo "Folder not found: $LOCAL_DIR"
    exit 1
fi

# Use sftp for recursive upload
upload_files() {
    local dir="$1"
    
    # Using sftp to upload files and directories recursively
    echo "Starting SFTP upload..."
    
    # Open an SFTP session and upload all files and directories recursively
    sftp -oBatchMode=no -b - "$USER@$HOST" <<EOF
    cd $REMOTE_DIR
    lcd $dir
    put -r *
    bye
EOF
}

# Start uploading from LOCAL_DIR
upload_files "$LOCAL_DIR"

