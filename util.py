def read_file(file_path):
    try:
        with open(file_path, 'r') as file:
            # Read the entire contents of the file
            file_contents = file.read()
            return file_contents.split('\n')
    except FileNotFoundError:
        print(f"Error: File '{file_path}' not found.")
    except Exception as e:
        print(f"Error: An unexpected error occurred - {e}")
