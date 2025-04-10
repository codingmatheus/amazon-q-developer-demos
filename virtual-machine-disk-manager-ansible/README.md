# VM Disk Addition Ansible App

This application uses Ansible to add a disk to a virtual machine.

## Prerequisites

- Ansible installed on the control machine
- SSH access to the target virtual machine
- Appropriate permissions to manage disks on the VM

## Directory Structure

```
.
├── README.md
├── ansible.cfg
├── inventory.yml
├── playbook.yml
└── roles/
    └── add_disk/
        ├── defaults/
        │   └── main.yml
        ├── tasks/
        │   └── main.yml
        └── handlers/
            └── main.yml
```

## Usage

1. Update the inventory file with your VM details
2. Modify the disk parameters in `roles/add_disk/defaults/main.yml`
3. Run the playbook:

```bash
ansible-playbook -i inventory.yml playbook.yml
```

## Configuration

You can customize the disk parameters in `roles/add_disk/defaults/main.yml`:

- `disk_device`: The device name for the new disk
- `disk_size`: Size of the disk to add
- `disk_mount_point`: Where to mount the new disk
- `disk_filesystem`: Filesystem type to format the disk with
